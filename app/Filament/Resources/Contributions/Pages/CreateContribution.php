<?php

namespace App\Filament\Resources\Contributions\Pages;

use App\Filament\Resources\Contributions\ContributionResource;
use App\Models\Contribution;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Facades\Filament;

class CreateContribution extends CreateRecord
{
    protected static string $resource = ContributionResource::class;

    protected function handleRecordCreation(array $data): Contribution
    {
        $monthlyRate = 300;

        $userId = $data['user_id'];
        $groupId = Filament::getTenant()->id;
        $amount = $data['amount'];
        $transactionCode = $data['transaction_code'];
        $startingPeriod = Carbon::parse($data['starting_period'])->startOfMonth();

        DB::beginTransaction();

        // Step 1: Create a single Contribution record for this payment
        $contribution = Contribution::create([
            'user_id' => $userId,
            'group_id' => $groupId,
            'amount' => $amount,
            'transaction_code' => $transactionCode,
            'contribution_date' => now(),
        ]);

        // Step 2: Apply payment to ContributionPeriods

        $remainingAmount = $amount;

        // Get or create contribution periods starting from the startingPeriod,
        // continuing forward until all amount is applied
        $period = $startingPeriod->copy();

        while ($remainingAmount > 0) {
            // Try to find existing period record or create new
            $contribPeriod = \App\Models\ContributionPeriod::firstOrCreate(
                [
                    'user_id' => $userId,
                    'group_id' => $groupId,
                    'period' => $period,
                ],
                [
                    'amount_due' => $monthlyRate,
                    'amount_paid' => 0,
                    'paid' => false,
                ]
            );

            $due = $contribPeriod->amount_due - $contribPeriod->amount_paid;

            if ($due <= 0) {
                // Already fully paid, move to next month
                $period->addMonth();
                continue;
            }

            if ($remainingAmount >= $due) {
                // Full payment for this period
                $contribPeriod->amount_paid = $contribPeriod->amount_due;
                $contribPeriod->paid = true;
                $remainingAmount -= $due;
            } else {
                // Partial payment
                $contribPeriod->amount_paid += $remainingAmount;
                $contribPeriod->paid = false;
                $remainingAmount = 0;
            }

            $contribPeriod->save();

            $period->addMonth();
        }

        DB::commit();

        return $contribution;
    }

}
