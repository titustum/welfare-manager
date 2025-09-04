<?php

namespace App\Filament\Resources\ContributionPeriods;

use App\Filament\Resources\ContributionPeriods\Pages\CreateContributionPeriod;
use App\Filament\Resources\ContributionPeriods\Pages\EditContributionPeriod;
use App\Filament\Resources\ContributionPeriods\Pages\ListContributionPeriods;
use App\Filament\Resources\ContributionPeriods\Pages\ViewContributionPeriod;
use App\Filament\Resources\ContributionPeriods\Schemas\ContributionPeriodForm;
use App\Filament\Resources\ContributionPeriods\Schemas\ContributionPeriodInfolist;
use App\Filament\Resources\ContributionPeriods\Tables\ContributionPeriodsTable;
use App\Models\ContributionPeriod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContributionPeriodResource extends Resource
{
    protected static ?string $model = ContributionPeriod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Calendar;

    protected static ?string $recordTitleAttribute = 'amount';

    public static function form(Schema $schema): Schema
    {
        return ContributionPeriodForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContributionPeriodInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContributionPeriodsTable::configure($table);
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
            'index' => ListContributionPeriods::route('/'),
            'create' => CreateContributionPeriod::route('/create'),
            'view' => ViewContributionPeriod::route('/{record}'),
            'edit' => EditContributionPeriod::route('/{record}/edit'),
        ];
    }
}
