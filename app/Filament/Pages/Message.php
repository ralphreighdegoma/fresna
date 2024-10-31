<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Message extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static string $view = 'filament.pages.message';

    //change navigation title
    protected static ?string $navigationLabel = 'Inbox';

    protected static ?int $navigationSort = 4;

    //hide in navigation
    protected static bool $shouldRegisterNavigation = true;
}
