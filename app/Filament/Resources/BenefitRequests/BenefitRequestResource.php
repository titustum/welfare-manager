<?php

namespace App\Filament\Resources\BenefitRequests;

use App\Filament\Resources\BenefitRequests\Pages\CreateBenefitRequest;
use App\Filament\Resources\BenefitRequests\Pages\EditBenefitRequest;
use App\Filament\Resources\BenefitRequests\Pages\ListBenefitRequests;
use App\Filament\Resources\BenefitRequests\Pages\ViewBenefitRequest;
use App\Filament\Resources\BenefitRequests\Schemas\BenefitRequestForm;
use App\Filament\Resources\BenefitRequests\Schemas\BenefitRequestInfolist;
use App\Filament\Resources\BenefitRequests\Tables\BenefitRequestsTable;
use App\Models\BenefitRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BenefitRequestResource extends Resource
{
    protected static ?string $model = BenefitRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Newspaper;

    protected static ?string $recordTitleAttribute = 'benefit_type_id';

    public static function form(Schema $schema): Schema
    {
        return BenefitRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BenefitRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BenefitRequestsTable::configure($table);
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
            'index' => ListBenefitRequests::route('/'),
            'create' => CreateBenefitRequest::route('/create'),
            'view' => ViewBenefitRequest::route('/{record}'),
            'edit' => EditBenefitRequest::route('/{record}/edit'),
        ];
    }
}
