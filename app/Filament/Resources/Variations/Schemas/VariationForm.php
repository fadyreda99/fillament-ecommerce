<?php

namespace App\Filament\Resources\Variations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VariationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
