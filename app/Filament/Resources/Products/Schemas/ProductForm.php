<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('cost_price')
                    ->numeric()
                    ->prefix('$'),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->native(false)
                    ->preload()
                    ->required(),

                TextInput::make('sku')
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->default('1')
                    ->native(false)

                    ->required()
                    ->columnSpan(1),
                FileUpload::make('featured_image')
                    ->label('Image')
                    ->image()
                    ->directory('products/featured/images')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
