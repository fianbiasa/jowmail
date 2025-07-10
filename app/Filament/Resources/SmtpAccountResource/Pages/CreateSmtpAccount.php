<?php

namespace App\Filament\Resources\SmtpAccountResource\Pages;

use App\Filament\Resources\SmtpAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSmtpAccount extends CreateRecord
{
    protected static string $resource = SmtpAccountResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}

}