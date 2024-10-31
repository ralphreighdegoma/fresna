<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Library extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static string $view = 'filament.pages.library';

    protected static ?int $navigationSort = 2;

    //disable nav

}
