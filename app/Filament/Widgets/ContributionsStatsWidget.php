<?php

namespace App\Filament\Widgets;

use App\Models\Contribution;
use App\Models\ContributionPeriod;
use App\Models\Disbursement;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;

class ContributionsStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $group = Filament::getTenant();
        $groupId = $group->id;
        $monthlyRate = 300;
        $currentMonth = Carbon::now()->startOfMonth();

        // Basic calculations
        $totalMembers = $group->users()->count();
        $expectedThisMonth = $totalMembers * $monthlyRate;
        $actualPaidThisMonth = ContributionPeriod::where('group_id', $groupId)
            ->where('period', $currentMonth)
            ->sum('amount_paid');
        $unpaidMembers = ContributionPeriod::where('group_id', $groupId)
            ->where('period', $currentMonth)
            ->where('paid', false)
            ->distinct('user_id')
            ->count('user_id');
        $totalContributions = Contribution::where('group_id', $groupId)->sum('amount');
        $totalDisbursed = Disbursement::where('group_id', $groupId)->sum('amount');
        $availableBalance = $totalContributions - $totalDisbursed;

        // Calculate percentages and trends
        $collectionRate = $expectedThisMonth > 0 ? ($actualPaidThisMonth / $expectedThisMonth) * 100 : 0;
        $paidMembers = $totalMembers - $unpaidMembers;
        $memberPaymentRate = $totalMembers > 0 ? ($paidMembers / $totalMembers) * 100 : 0;

        return [
            // Current Month Performance (combines expected, collected, and collection rate)
            Stat::make('Monthly Collection Progress', 'Ksh ' . number_format($actualPaidThisMonth) . ' / ' . number_format($expectedThisMonth))
                ->description(number_format($collectionRate, 1) . '% collected • ' . $paidMembers . '/' . $totalMembers . ' members paid')
                ->descriptionIcon($collectionRate >= 80 ? 'heroicon-m-arrow-trending-up' : ($collectionRate >= 50 ? 'heroicon-m-minus' : 'heroicon-m-arrow-trending-down'))
                ->color($collectionRate >= 80 ? 'success' : ($collectionRate >= 50 ? 'warning' : 'danger'))
                ->chart($this->getCollectionChart($collectionRate)),

            // Member Status (combines total members and unpaid status)
            Stat::make('Member Status', $totalMembers . ' Total')
                ->description($unpaidMembers > 0 ? $unpaidMembers . ' still owe for ' . $currentMonth->format('F') : 'All payments up to date!')
                ->descriptionIcon($unpaidMembers > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($unpaidMembers == 0 ? 'success' : ($unpaidMembers <= $totalMembers * 0.2 ? 'warning' : 'danger')),

            // Financial Overview (combines available balance with disbursement context)
            Stat::make('Pool Balance', 'Ksh ' . number_format($availableBalance, 2))
                ->description('From Ksh ' . number_format($totalContributions, 2) . ' total • Ksh ' . number_format($totalDisbursed, 2) . ' disbursed')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($availableBalance > ($totalContributions * 0.1) ? 'success' : 'warning')
                ->chart($this->getBalanceChart($totalContributions, $totalDisbursed)),
        ];
    }

    /**
     * Generate a simple chart array for collection progress
     */
    private function getCollectionChart(float $collectionRate): array
    {
        // Simple ascending chart if collection is good, declining if poor
        if ($collectionRate >= 70) {
            return [10, 20, 35, 50, 70, 85, min(100, $collectionRate)];
        } else {
            return [80, 70, 60, 55, 50, 45, max(0, $collectionRate)];
        }
    }

    /**
     * Generate a simple chart array for balance visualization
     */
    private function getBalanceChart(float $totalContributions, float $totalDisbursed): array
    {
        if ($totalContributions == 0) {
            return [0, 0, 0, 0, 0];
        }
        
        // Show growth pattern for healthy balance, decline for concerning balance
        $balanceRatio = ($totalContributions - $totalDisbursed) / $totalContributions;
        
        if ($balanceRatio > 0.3) {
            return [20, 35, 50, 70, 85];
        } else {
            return [85, 70, 50, 35, max(10, $balanceRatio * 100)];
        }
    }
}