<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
//TextInput
use Filament\Forms\Components\TextInput;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function getFormActions(): array
    {
        return [];
    }
    

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
