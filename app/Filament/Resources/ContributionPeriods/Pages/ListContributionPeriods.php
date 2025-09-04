<?php

namespace App\Filament\Resources\ContributionPeriods\Pages;

use App\Filament\Resources\ContributionPeriods\ContributionPeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContributionPeriods extends ListRecords
{
    protected static string $resource = ContributionPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
