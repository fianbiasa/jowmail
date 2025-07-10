<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailListResource\Pages;
use App\Models\EmailList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class EmailListResource extends Resource
{
    protected static ?string $model = EmailList::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('subscribers_count')
                ->counts('subscribers')
                ->label('Total Subscribers'),
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
            'index' => Pages\ListEmailLists::route('/'),
            'create' => Pages\CreateEmailList::route('/create'),
            'edit' => Pages\EditEmailList::route('/{record}/edit'),
        ];
    }
}