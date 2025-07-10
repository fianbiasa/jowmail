<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriberResource\Pages;
use App\Models\Subscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Subscribers';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('email')->email()->required(),
            TextInput::make('name')->label('Subscriber Name')->required(),
            Select::make('email_list_id')
                ->label('Email List')
                ->relationship('emailList', 'name')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('email')->sortable()->searchable(),
            TextColumn::make('emailList.name')->label('List'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribers::route('/'),
            'create' => Pages\CreateSubscriber::route('/create'),
            'edit' => Pages\EditSubscriber::route('/{record}/edit'),
        ];
    }
}