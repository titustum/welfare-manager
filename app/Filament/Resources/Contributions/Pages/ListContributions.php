<?php

namespace App\Filament\Resources\Contributions\Pages;

use App\Filament\Resources\Contributions\ContributionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContributions extends ListRecords
{
    protected static string $resource = ContributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
