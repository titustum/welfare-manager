<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('student_id'),
                TextInput::make('staff_id'),
                TextInput::make('role')
                    ->required()
                    ->default('member'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                DatePicker::make('joined_at')
                    ->required(),
            ]);
    }
}
