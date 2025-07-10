<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmtpAccountResource\Pages;
use App\Models\SmtpAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, BooleanColumn};
use Illuminate\Database\Eloquent\Builder;

class SmtpAccountResource extends Resource
{
    protected static ?string $model = SmtpAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'SMTP';
    protected static ?string $pluralModelLabel = 'SMTP Accounts';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama SMTP')
                    ->required(),

                TextInput::make('host')
                    ->required(),

                TextInput::make('port')
                    ->numeric()
                    ->required(),

                TextInput::make('username')
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(),

                TextInput::make('encryption')
                    ->label('Encryption (tls/ssl)')
                    ->default('tls'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('SMTP Name')->searchable(),
                TextColumn::make('host'),
                TextColumn::make('port'),
                TextColumn::make('username'),
                TextColumn::make('encryption'),
                BooleanColumn::make('is_active')
                ->label('Aktif'),
                TextColumn::make('created_at')->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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