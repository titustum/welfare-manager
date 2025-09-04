<?php

namespace App\Filament\Resources\ContributionPeriods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContributionPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('contribution_id')
                    ->relationship('contribution', 'id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('group_id')
                    ->relationship('group', 'name')
                    ->required(),
                TextInput::make('month')
                    ->required()
                    ->numeric(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(300),
            ]);
    }
}
