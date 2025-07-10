<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DateTimePicker;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'Campaigns';

    public static function form(Form $form): Form
    {
        return $form->schema([
        TextInput::make('subject')->required(),
        Textarea::make('body')->label('Email Content')->rows(8)->required(),
        Select::make('smtp_account_id')
            ->label('SMTP Account')
            ->relationship('smtpAccount', 'name')
            ->required(),
        Select::make('email_list_id')
            ->label('Email List')
            ->relationship('emailList', 'name')
            ->required(),
        DateTimePicker::make('scheduled_at')
            ->label('Schedule Send Time')
            ->nullable()
            ->default(now())
            ->seconds(false),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('subject')->sortable()->searchable(),
            TextColumn::make('smtpAccount.name')->label('SMTP'),
            TextColumn::make('emailList.name')->label('Email List'),
            BadgeColumn::make('status')->colors([
                'success' => 'sent',
                'danger' => 'failed',
                'gray' => 'draft',
            ]),
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
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}