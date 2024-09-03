<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationLabel = 'Rezervasiyalar';

    protected static ?string $label = 'Rezervasiya';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('customer_name')->required()->label('Müştəri adı'),
                    TextInput::make('customer_phone')->required()->label('Müştəri nömrəsi'),
                    Select::make('barber_id')->relationship('barber', 'name')->required()->label('Bərbərin adı'),
                    DateTimePicker::make('reservation_date')->required()->label('Rezervasiya tarixi'),
                    TextInput::make('total_price')->required()->label('Cəmi məbləğ')->suffix(' AZN'),
                    TextInput::make('service_charge')->required()->label('Çayavoy')->suffix(' AZN'),
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Müştəri adı')->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')->label('Müştəri nömrəsi'),
                Tables\Columns\TextColumn::make('reservation_date')->label('Rezervasiya tarixi')->date(),
                Tables\Columns\TextColumn::make('barber.name')->label('Bərbərin adı'),
                Tables\Columns\TextColumn::make('total_price')->label('Cəmi məbləğ')->money('AZN'),
                Tables\Columns\TextColumn::make('service_charge')->label('Çayavoy')->money('AZN'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListReservations::route('/'),
           // 'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
