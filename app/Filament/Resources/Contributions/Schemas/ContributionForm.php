<?php

namespace App\Filament\Resources\Contributions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContributionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Member')
                    ->required(),
                // Select::make('group_id')
                //     ->relationship('group', 'name')
                //     ->required(),
                DatePicker::make('starting_period')
                    ->required()
                    ->default(now()->startOfMonth()),
                DatePicker::make('period')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('transaction_code'),
            ]);
    }
}
