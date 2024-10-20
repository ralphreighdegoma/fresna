<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Compose extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.compose';

    protected static ?string $navigationGroup = 'Messaging';

}
