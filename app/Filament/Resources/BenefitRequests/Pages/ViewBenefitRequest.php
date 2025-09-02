<?php

namespace App\Filament\Resources\BenefitRequests\Pages;

use App\Filament\Resources\BenefitRequests\BenefitRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBenefitRequest extends ViewRecord
{
    protected static string $resource = BenefitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
