<?php

namespace App\Filament\Resources\BenefitTypes\Pages;

use App\Filament\Resources\BenefitTypes\BenefitTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBenefitType extends EditRecord
{
    protected static string $resource = BenefitTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
