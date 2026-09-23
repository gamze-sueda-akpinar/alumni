<?php

namespace App\Filament\Resources\AlumniProfileResource\Pages;

use App\Filament\Resources\AlumniProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlumniProfiles extends ListRecords
{
    protected static string $resource = AlumniProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
