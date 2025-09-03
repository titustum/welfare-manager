<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Group;
use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterGroup extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('description'), 
            ]);
    }
    

    protected function handleRegistration(array $data): Group
    {
        $group = Group::create($data);

        $group->users()->attach(auth()->user());

        return $group;
    }
}