<?php

namespace App\Filament\Resources\BenefitRequests\Pages;

use App\Filament\Resources\BenefitRequests\BenefitRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBenefitRequests extends ListRecords
{
    protected static string $resource = BenefitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
