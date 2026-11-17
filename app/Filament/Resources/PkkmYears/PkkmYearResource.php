<?php

namespace App\Filament\Resources\PkkmYears;

use App\Filament\Resources\PkkmYears\Pages\CreatePkkmYear;
use App\Filament\Resources\PkkmYears\Pages\EditPkkmYear;
use App\Filament\Resources\PkkmYears\Pages\ListPkkmYears;
use App\Filament\Resources\PkkmYears\Schemas\PkkmYearForm;
use App\Filament\Resources\PkkmYears\Tables\PkkmYearsTable;
use App\Models\PkkmYear;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PkkmYearResource extends Resource
{
    protected static ?string $model = PkkmYear::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'PKKM';

    protected static ?string $modelLabel = 'PKKM';

    protected static ?string $pluralModelLabel = 'PKKM per Tahun';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PkkmYearForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PkkmYearsTable::configure($table);
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
            'index' => ListPkkmYears::route('/'),
            'create' => CreatePkkmYear::route('/create'),
            'edit' => EditPkkmYear::route('/{record}/edit'),
        ];
    }
}
