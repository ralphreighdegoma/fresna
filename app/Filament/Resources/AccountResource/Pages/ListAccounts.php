<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Tag;
use Filament\Forms\Components\Html;
//action
use Filament\Tables\Actions\Action as TablesAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;


//MODAL
use Filament\Forms\Components\Modal;
//TextInput
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class ListAccounts extends ListRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {

        return [
            
            Action::make('customCreate')
                ->label('Connect')
                ->modalHeading('Connect to Account Provider')
                ->action(function (array $data, \App\Models\Account $account): void {

                    //connect to UnipileService
                    $unipile = new \App\Services\UnipileService();
                    $host = $unipile->createHostedAccountLink();

                    ///redirect page to specific url
                    $url = $host['url'];
                    redirect()->away($url);

                })
                ->requiresConfirmation()
                ->color('success'), // Action color
                //submit
        ];
    }

    protected function getActions(): array
    {
        return [];
    }
}
