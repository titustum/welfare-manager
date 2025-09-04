<?php

namespace App\Filament\Resources\ContributionPeriods\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContributionPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('group_id')
                    ->relationship('group', 'name')
                    ->required(),
                DatePicker::make('period')
                    ->required(),
                TextInput::make('amount_due')
                    ->required()
                    ->numeric()
                    ->default(300),
                TextInput::make('amount_paid')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('paid')
                    ->required(),
            ]);
    }
}
