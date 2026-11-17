<?php

namespace App\Filament\Resources\MenuItems\RelationManagers;

use App\Filament\Resources\MenuItems\Schemas\MenuItemForm;
use App\Filament\Resources\MenuItems\Tables\MenuItemsTable;
use App\Models\MenuItem;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    protected static ?string $title = 'Sub-menu';

    protected static ?string $modelLabel = 'Sub-menu';

    /**
     * Only top-level items can have children (max 2 levels).
     */
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord instanceof MenuItem && $ownerRecord->parent_id === null;
    }

    public function form(Schema $schema): Schema
    {
        return MenuItemForm::configure($schema, withParent: false);
    }

    public function table(Table $table): Table
    {
        return MenuItemsTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
