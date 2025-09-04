<?php

namespace App\Filament\Resources\Contributions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContributionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name'),
                TextEntry::make('group.name'),
                TextEntry::make('period')
                    ->date(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('transaction_code'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
