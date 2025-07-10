<?php

namespace App\Filament\Resources\EmailListResource\Pages;

use App\Filament\Resources\EmailListResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmailList extends CreateRecord
{
    protected static string $resource = EmailListResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}