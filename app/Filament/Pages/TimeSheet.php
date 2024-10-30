<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TimeSheet extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.time-sheet';

    protected static ?string $slug = 'my-time-sheet';
}
