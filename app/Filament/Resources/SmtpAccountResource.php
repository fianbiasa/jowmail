<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmtpAccountResource\Pages;
use App\Models\SmtpAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class SmtpAccountResource extends Resource
{
    protected static ?string $model = SmtpAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';
    protected static ?string $navigationLabel = 'SMTP Accounts';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('host')->required(),
            TextInput::make('port')->numeric()->required(),
            Select::make('encryption')
                ->options([
                    'tls' => 'TLS',
                    'ssl' => 'SSL',
                    'null' => 'None',
                ])
                ->required(),
            TextInput::make('username')->required(),
            TextInput::make('password')->password()->required(),
            TextInput::make('from_name')->label('Sender Name')->required(),
            TextInput::make('from_address')->label('Sender Email')->email()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('host'),
            TextColumn::make('port'),
            TextColumn::make('encryption'),
            TextColumn::make('from_name')->label('Sender Name'),
            TextColumn::make('from_address')->label('Sender Email'),
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
            'index' => Pages\ListSmtpAccounts::route('/'),
            'create' => Pages\CreateSmtpAccount::route('/create'),
            'edit' => Pages\EditSmtpAccount::route('/{record}/edit'),
        ];
    }
}