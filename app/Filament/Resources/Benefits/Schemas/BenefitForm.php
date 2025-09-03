<?php

namespace App\Filament\Resources\Benefits\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BenefitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([ 
                TextInput::make('name')
                    ->required(),
                TextInput::make('default_amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
