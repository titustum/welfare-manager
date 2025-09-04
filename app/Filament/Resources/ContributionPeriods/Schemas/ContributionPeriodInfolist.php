<?php

namespace App\Filament\Resources\ContributionPeriods\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContributionPeriodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name'),
                TextEntry::make('group.name'),
                TextEntry::make('period')
                    ->date(),
                TextEntry::make('amount_due')
                    ->numeric(),
                TextEntry::make('amount_paid')
                    ->numeric(),
                IconEntry::make('paid')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
