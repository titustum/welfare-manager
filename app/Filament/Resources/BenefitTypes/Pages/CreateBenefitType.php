<?php

namespace App\Filament\Resources\BenefitTypes\Pages;

use App\Filament\Resources\BenefitTypes\BenefitTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBenefitType extends CreateRecord
{
    protected static string $resource = BenefitTypeResource::class;
}
