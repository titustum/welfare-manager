<?php

namespace App\Filament\Resources\BenefitTypes\Pages;

use App\Filament\Resources\BenefitTypes\BenefitTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBenefitType extends ViewRecord
{
    protected static string $resource = BenefitTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
