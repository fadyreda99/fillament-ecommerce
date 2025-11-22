<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media'; // <<< important

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('file_path')
                ->label('Image')
                ->image()
                ->directory('products/images')
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_path')
            ->columns([
                ImageColumn::make('file_path')->label('Image')->square(),
            ])
            ->headerActions([
                // Normal upload (one image per record)
                CreateAction::make(),

                // Bulk Upload
                CreateAction::make('upload-multiple')
                    ->label('Upload Multiple Images')
                    ->form([
                        FileUpload::make('files')
                            ->label('Images')
                            ->multiple()
                            ->directory('products/images')
                            ->required()
                            ->image(),
                    ])
                    ->action(function ($data, $record) {
                        foreach ($data['files'] as $file) {
                            $this->getOwnerRecord()->media()->create([
                                'file_path' => $file,
                            ]);
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order') // ← for drag & drop sorting
            ->defaultSort('sort_order');
    }
}
