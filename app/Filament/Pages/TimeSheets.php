<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TimeSheets extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.pages.time-sheets';

    protected static ?int $navigationSort = 8;

}
