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
            'period' => $startingPeriod, // Optional: if you want to track starting period on contribution itself
            'contribution_date' => now(),
        ]);

        // Step 2: Apply payment to ContributionPeriods
        $remainingAmount = $amount;
        $period = $startingPeriod->copy();

        while ($remainingAmount > 0) {
            // Find or create the ContributionPeriod record for the current month
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
                // This period is already fully paid, move to next month
                $period->addMonth();
                continue;
            }

            if ($remainingAmount >= $due) {
                // Full payment for this period
                $contribPeriod->amount_paid = $contribPeriod->amount_due;
                $contribPeriod->paid = true;
                $remainingAmount -= $due;
            } else {
                // Partial payment for this period
                $contribPeriod->amount_paid += $remainingAmount;
                $contribPeriod->paid = false;
                $remainingAmount = 0;
            }

            $contribPeriod->save();

            // Move to next month for next iteration/payment allocation
            $period->addMonth();
        }

        DB::commit();

        return $contribution;
    }
}
