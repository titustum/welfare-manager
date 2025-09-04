<?php

namespace App\Filament\Resources\ContributionPeriods\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContributionPeriodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('contribution.id'),
                TextEntry::make('user.name'),
                TextEntry::make('group.name'),
                TextEntry::make('month')
                    ->numeric(),
                TextEntry::make('year')
                    ->numeric(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
