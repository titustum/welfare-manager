<?php

namespace App\Filament\Resources\BenefitRequests\Pages;

use App\Filament\Resources\BenefitRequests\BenefitRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBenefitRequest extends EditRecord
{
    protected static string $resource = BenefitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
