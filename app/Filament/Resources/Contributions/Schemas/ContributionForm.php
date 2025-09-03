<?php

namespace App\Filament\Resources\Contributions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContributionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                DatePicker::make('contribution_date')
                    ->required(),
                TextInput::make('payment_method')
                    ->required(),
                TextInput::make('reference_no'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
            ]);
    }
}
