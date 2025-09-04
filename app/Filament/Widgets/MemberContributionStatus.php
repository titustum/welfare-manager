<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class MemberContributionStatus extends BaseWidget
{
    protected static ?int $sort = 2;

    // Make widget span full width
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        $group = Filament::getTenant();

        return User::whereHas('groups', fn ($q) => $q->where('group_id', $group->id))
            ->withCount([
                'contributionPeriods as paid_months_count' => fn ($q) => $q->where('group_id', $group->id)->where('paid', true),
                'contributionPeriods as unpaid_months_count' => fn ($q) => $q->where('group_id', $group->id)->where('paid', false),
                'contributionPeriods as total_periods_count' => fn ($q) => $q->where('group_id', $group->id),
            ])
            ->withSum('contributionPeriods as total_paid_sum', 'amount_paid');
    }

    protected function getTableColumns(): array
    {
        $monthlyRate = 300;

        return [
            // Member with status icon
            Tables\Columns\TextColumn::make('name')
                ->label('Member')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->formatStateUsing(function (string $state, Model $record) use ($monthlyRate) {
                    $expected = $record->total_periods_count * $monthlyRate;
                    $paid = $record->total_paid_sum ?? 0;
                    $balance = $paid - $expected;

                    $statusIcon = match (true) {
                        $balance >= 0 && $record->unpaid_months_count == 0 => '✅',
                        $balance >= 0 && $record->unpaid_months_count > 0 => '⚠️',
                        $balance < 0 => '🔴',
                        default => '⭕',
                    };

                    return $statusIcon . ' ' . $state;
                }),

            // Payment status badge
            Tables\Columns\TextColumn::make('payment_status')
                ->label('Payment Status')
                ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('paid_months_count', $direction))
                ->formatStateUsing(function (Model $record) {
                    $paidMonths = $record->paid_months_count ?? 0;
                    $unpaidMonths = $record->unpaid_months_count ?? 0;

                    $status = $paidMonths . '/' . ($paidMonths + $unpaidMonths) . ' months';
                    if ($unpaidMonths > 0) {
                        $status .= ' • ' . $unpaidMonths . ' overdue';
                    }

                    return $status;
                })
                ->badge()
                ->color(fn (Model $record) => match (true) {
                    ($record->unpaid_months_count ?? 0) == 0 => 'success',
                    ($record->unpaid_months_count ?? 0) <= 2 => 'warning',
                    default => 'danger',
                }),

            // Financial summary with colors
            Tables\Columns\TextColumn::make('financial_summary')
                ->label('Financial Summary')
                ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('total_paid_sum', $direction))
                ->formatStateUsing(function (Model $record) use ($monthlyRate) {
                    $expected = $record->total_periods_count * $monthlyRate;
                    $paid = $record->total_paid_sum ?? 0;
                    $balance = $paid - $expected;

                    $summary = 'Paid: Ksh ' . number_format($paid, 0);
                    if ($balance != 0) {
                        $summary .= ' • ' . ($balance > 0 ? 'Credit' : 'Owes') . ': Ksh ' . number_format(abs($balance), 0);
                    }

                    return $summary;
                })
                ->color(function (Model $record) use ($monthlyRate): string {
                    $expected = $record->total_periods_count * $monthlyRate;
                    $paid = $record->total_paid_sum ?? 0;
                    $balance = $paid - $expected;

                    return match (true) {
                        $balance > 0 => 'success',
                        $balance == 0 => 'gray',
                        $balance >= -($monthlyRate * 2) => 'warning', // up to 2 months behind
                        default => 'danger',
                    };
                }),

            // Contact with email copy & tooltip
            Tables\Columns\TextColumn::make('contact')
                ->label('Contact')
                ->formatStateUsing(fn (Model $record) => $record->email)
                ->limit(25)
                ->tooltip(fn (Model $record): ?string => $record->email)
                ->copyable()
                ->copyMessage('Email copied!')
                ->icon('heroicon-m-envelope')
                ->iconColor('gray'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('payment_status')
                ->label('Payment Status')
                ->options([
                    'up_to_date' => 'Up to Date',
                    'behind' => 'Behind on Payments',
                    'overdue' => 'Overdue (3+ months)',
                ])
                ->query(function (Builder $query, array $data): Builder {
                    $monthlyRate = 300;

                    return match ($data['value'] ?? null) {
                        'up_to_date' => $query->having('unpaid_months_count', '=', 0),
                        'behind' => $query->having('unpaid_months_count', '>', 0)
                            ->having('unpaid_months_count', '<=', 2),
                        'overdue' => $query->having('unpaid_months_count', '>', 2),
                        default => $query,
                    };
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('send_reminder')
                ->label('Send Reminder')
                ->icon('heroicon-m-bell-alert')
                ->color('warning')
                ->visible(fn (Model $record): bool => $record->unpaid_months_count > 0)
                ->action(function (Model $record) {
                    // Implement your reminder logic here, e.g. dispatch job or send notification
                    $this->notify('success', "Reminder sent to {$record->name}!");
                }),
        ];
    }

    public function getTableHeading(): string
    {
        return 'Member Payment Overview';
    }

    protected function getTableDescription(): ?string
    {
        $group = Filament::getTenant();

        $totalMembers = User::whereHas('groups', fn ($q) => $q->where('group_id', $group->id))->count();

        $upToDate = User::whereHas('groups', fn ($q) => $q->where('group_id', $group->id))
            ->whereDoesntHave('contributionPeriods', fn ($q) =>
                $q->where('group_id', $group->id)->where('paid', false)
            )->count();

        return "Showing payment status for {$totalMembers} members • {$upToDate} up to date • " . ($totalMembers - $upToDate) . " behind on payments";
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No members found';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'There are no members in this group yet.';
    }
}
