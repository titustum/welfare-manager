<?php

namespace App\Filament\Resources\BenefitTypes\Pages;

use App\Filament\Resources\BenefitTypes\BenefitTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBenefitTypes extends ListRecords
{
    protected static string $resource = BenefitTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
