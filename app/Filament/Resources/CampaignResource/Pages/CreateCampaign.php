<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use App\Jobs\SendCampaignEmail;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCampaign extends CreateRecord
{
    protected static string $resource = CampaignResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);
        $record->load('smtpAccount', 'emailList.subscribers');
        SendCampaignEmail::dispatch($record);
        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}