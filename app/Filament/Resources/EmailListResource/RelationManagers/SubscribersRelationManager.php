<?php

namespace App\Filament\Resources\EmailListResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class SubscribersRelationManager extends RelationManager
{
    protected static string $relationship = 'subscribers';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')->label('Name'),
            TextInput::make('email')->email()->required(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('created_at')->dateTime('d M Y H:i'),
        ])
        ->filters([])
        ->headerActions([
            Tables\Actions\CreateAction::make(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }
}