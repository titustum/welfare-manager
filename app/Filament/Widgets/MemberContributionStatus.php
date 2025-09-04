<?php

namespace App\Filament\Widgets;

use App\Models\ContributionPeriod;
use App\Models\User;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;

class MemberContributionStatus extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 2;

    protected function getTableQuery(): Builder
    {
        $group = Filament::getTenant();

        // Eager load contribution periods summary using withCount and withSum for better performance
        return User::whereHas('groups', fn ($q) => $q->where('group_id', $group->id))
            ->withCount([
                'contributionPeriods as paid_months' => fn ($q) => $q->where('group_id', $group->id)->where('paid', true),
                'contributionPeriods as unpaid_months' => fn ($q) => $q->where('group_id', $group->id)->where('paid', false),
                'contributionPeriods as total_periods' => fn ($q) => $q->where('group_id', $group->id),
            ])
            ->withSum([
                'contributionPeriods as total_amount_paid' => fn ($q) => $q->where('group_id', $group->id),
            ], 'amount_paid');
    }

    protected function getTableColumns(): array
    {
        $monthlyRate = 300;

        return [
            TextColumn::make('name')
                ->label('Member')
                ->searchable()
                ->sortable()
                ->weight('medium'),

            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable()
                ->limit(30)
                ->tooltip(fn ($state) => $state)
                ->copyable(),

            TextColumn::make('paid_months')
                ->label('Months Paid')
                ->sortable()
                ->getStateUsing(fn ($record) => $record->paid_months),

            TextColumn::make('unpaid_months')
                ->label('Unpaid Months')
                ->sortable()
                ->getStateUsing(fn ($record) => $record->unpaid_months)
                ->color(fn ($state) => match (true) {
                    $state == 0 => 'success',
                    $state <= 2 => 'warning',
                    default => 'danger',
                }),

            TextColumn::make('total_amount_paid')
                ->label('Total Paid (Ksh)')
                ->sortable()
                ->getStateUsing(fn ($record) => number_format($record->total_amount_paid ?? 0, 2)),

            TextColumn::make('balance')
                ->label('Balance')
                ->sortable()
                ->getStateUsing(function ($record) use ($monthlyRate) {
                    $expected = $record->total_periods * $monthlyRate;
                    $paid = $record->total_amount_paid ?? 0;
                    $balance = $paid - $expected;

                    return number_format($balance, 2);
                })
                ->color(function ($record) use ($monthlyRate) {
                    $expected = $record->total_periods * $monthlyRate;
                    $paid = $record->total_amount_paid ?? 0;
                    $balance = $paid - $expected;

                    return match (true) {
                        $balance < 0 => 'danger',
                        $balance == 0 => 'primary',
                        $balance > 0 => 'success',
                    };
                }),

            TextColumn::make('payment_status')
                ->label('Status')
                ->badge()
                ->getStateUsing(function ($record) {
                    if ($record->unpaid_months === 0) {
                        return 'Up to Date';
                    }

                    if ($record->unpaid_months <= 2) {
                        return 'Behind';
                    }

                    return 'Overdue';
                })
                ->colors([
                    'success' => 'Up to Date',
                    'warning' => 'Behind',
                    'danger' => 'Overdue',
                ])
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('payment_status')
                ->label('Payment Status')
                ->options([
                    'up_to_date' => 'Up to Date',
                    'behind' => 'Behind',
                    'overdue' => 'Overdue',
                ])
                ->query(function (Builder $query, array $data) {
                    $group = Filament::getTenant();

                    return match ($data['value'] ?? null) {
                        'up_to_date' => $query->having('unpaid_months', '=', 0),
                        'behind' => $query->having('unpaid_months', '>', 0)->having('unpaid_months', '<=', 2),
                        'overdue' => $query->having('unpaid_months', '>', 2),
                        default => $query,
                    };
                }),
        ];
    }

    public function getTableHeading(): string
    {
        return 'Member Contribution Summary';
    }
}
