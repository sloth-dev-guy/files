<?php

use Illuminate\Support\Facades\Route;
use SlothDevGuy\Files\Http\Controllers\FilesController;

Route::prefix('files')
    ->as('files.')
    ->group(function (){
        Route::post('/', [FilesController::class, 'store'])->name('store');
    });
