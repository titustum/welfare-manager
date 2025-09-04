<?php

namespace App\Filament\Resources\ContributionPeriods\Pages;

use App\Filament\Resources\ContributionPeriods\ContributionPeriodResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContributionPeriod extends ViewRecord
{
    protected static string $resource = ContributionPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
