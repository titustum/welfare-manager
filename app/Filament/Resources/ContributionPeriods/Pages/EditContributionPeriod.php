<?php

namespace App\Filament\Resources\ContributionPeriods\Pages;

use App\Filament\Resources\ContributionPeriods\ContributionPeriodResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditContributionPeriod extends EditRecord
{
    protected static string $resource = ContributionPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
