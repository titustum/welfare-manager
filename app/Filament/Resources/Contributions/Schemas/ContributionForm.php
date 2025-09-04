<?php

namespace App\Filament\Resources\Contributions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContributionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                DatePicker::make('starting_period')
                    ->label('Start Month')
                    ->required()
                    ->displayFormat('F Y')
                    ->default(now()->startOfMonth()),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                DatePicker::make('contribution_date') 
                    ->default(now()),
                TextInput::make('transaction_code')
                    ->required(),
                TextInput::make('payment_method')
                    ->required()
                    ->default('mpesa'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
