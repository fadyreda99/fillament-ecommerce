<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                Select::make('type')
                    ->native(false)
                    ->options(['percentage' => 'Percentage', 'fixed' => 'Fixed'])
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric(),
                TextInput::make('min_cart_value')
                    ->numeric(),
                TextInput::make('usage_limit')
                    ->numeric(),
                TextInput::make('used_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                DatePicker::make('starts_at')->native(false),
                DatePicker::make('expires_at')->native(false),
                Toggle::make('active')->label('Active')->default(true),

            ]);
    }
}
