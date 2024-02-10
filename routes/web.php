<?php

use Illuminate\Support\Facades\Route;
use SlothDevGuy\Files\Http\Controllers\FilesController;

Route::prefix('files')
    ->as('files.')
    ->group(function (){
        Route::get('/', [FilesController::class, 'search'])->name('index');
        Route::post('/', [FilesController::class, 'store'])->name('store');
        Route::post('/search', [FilesController::class, 'search'])->name('search');

        Route::get('/{file}', [FilesController::class, 'show'])->name('show');
        Route::get('/{file}/download', [FilesController::class, 'download'])->name('download');
    });
