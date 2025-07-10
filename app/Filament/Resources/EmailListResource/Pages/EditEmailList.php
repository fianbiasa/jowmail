<?php

namespace App\Filament\Resources\EmailListResource\Pages;

use App\Filament\Resources\EmailListResource;
use App\Models\Subscriber;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class EditEmailList extends EditRecord
{
    protected static string $resource = EmailListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Import CSV')
                ->form([
                    FileUpload::make('csv')
                        ->label('CSV File')
                        ->disk('local')
                        ->directory('uploads')
                        ->acceptedFileTypes(['text/csv', 'text/plain'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $path = storage_path('app/' . $data['csv']);

                    if (!file_exists($path)) {
                        Notification::make()->title('File not found.')->danger()->send();
                        return;
                    }

                    $csv = array_map('str_getcsv', file($path));

                    $header = array_map('strtolower', array_shift($csv)); // first row = header
                    $emailIndex = array_search('email', $header);
                    $nameIndex = array_search('name', $header);

                    $imported = 0;

                    foreach ($csv as $row) {
                        $email = $row[$emailIndex] ?? null;
                        $name = $row[$nameIndex] ?? null;

                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            Subscriber::updateOrCreate([
                                'email_list_id' => $this->record->id,
                                'email' => $email,
                            ], [
                                'name' => $name,
                            ]);
                            $imported++;
                        }
                    }

                    Notification::make()
                        ->title("Imported {$imported} subscribers.")
                        ->success()
                        ->send();
                }),
        ];
    }
}