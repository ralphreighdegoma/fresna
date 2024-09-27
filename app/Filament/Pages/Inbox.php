<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Inbox extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.inbox';

    protected static ?string $navigationGroup = 'Messaging';


    //custom view
    public static function view(): string
    {
        return 'filament.pages.inbox-custom';
    }
}
