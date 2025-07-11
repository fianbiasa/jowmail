<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;

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

        TextColumn::make('sent_to')
            ->label('Sent To')
            ->getStateUsing(fn ($record) => $record->emailList?->subscribers()->count() ?? 0),

        TextColumn::make('opens_count')
            ->label('Opens')
            ->getStateUsing(fn ($record) => $record->opens()->count()),

        TextColumn::make('clicks_count')
            ->label('Clicks')
            ->getStateUsing(fn ($record) => $record->clicks()->count()),

        TextColumn::make('open_rate')
            ->label('Open Rate')
            ->getStateUsing(function ($record) {
                $total = $record->emailList?->subscribers()->count() ?: 1;
                return number_format($record->opens()->count() / $total * 100, 1) . '%';
            }),

        TextColumn::make('click_rate')
            ->label('Click Rate')
            ->getStateUsing(function ($record) {
                $total = $record->emailList?->subscribers()->count() ?: 1;
                return number_format($record->clicks()->count() / $total * 100, 1) . '%';
            }),
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