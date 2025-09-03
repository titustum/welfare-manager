<?php

namespace App\Filament\Resources\Contributions\Schemas;

use App\Models\User;
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
                    ->options(User::all()->pluck('name', 'id'))
                    // ->relationship('user', 'name')
                    // ->relationship('user', 'groups')
                    ->required(),
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
