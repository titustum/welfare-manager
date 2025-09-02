<?php

namespace App\Filament\Resources\BenefitTypes;

use App\Filament\Resources\BenefitTypes\Pages\CreateBenefitType;
use App\Filament\Resources\BenefitTypes\Pages\EditBenefitType;
use App\Filament\Resources\BenefitTypes\Pages\ListBenefitTypes;
use App\Filament\Resources\BenefitTypes\Pages\ViewBenefitType;
use App\Filament\Resources\BenefitTypes\Schemas\BenefitTypeForm;
use App\Filament\Resources\BenefitTypes\Schemas\BenefitTypeInfolist;
use App\Filament\Resources\BenefitTypes\Tables\BenefitTypesTable;
use App\Models\BenefitType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BenefitTypeResource extends Resource
{
    protected static ?string $model = BenefitType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::AcademicCap;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BenefitTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BenefitTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BenefitTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBenefitTypes::route('/'),
            'create' => CreateBenefitType::route('/create'),
            'view' => ViewBenefitType::route('/{record}'),
            'edit' => EditBenefitType::route('/{record}/edit'),
        ];
    }
}
