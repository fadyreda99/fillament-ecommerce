<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\Variation;
use App\Models\VariationValue;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VariationsRelationManager extends RelationManager
{
    protected static string $relationship = 'Variations';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('variation_id')
                    ->label('Variation Type')
                    ->options(Variation::pluck('name', 'id'))
                    ->required()
                    ->native(false)

                    ->live(), // << مهم جداً

                Select::make('variation_value_id')
                    ->label('Value')
                    ->options(
                        fn($get) =>
                        VariationValue::where('variation_id', $get('variation_id'))
                            ->pluck('value', 'id')
                    )
                    ->required()
                    ->native(false)
                    ->disabled(fn($get) => blank($get('variation_id'))),

                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('products/variations/images')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('variation.name')->label('Type'),
                TextColumn::make('variationValue.value')->label('Value'),
                ImageColumn::make('image')->label('Image')->rounded(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
