<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return response()->json(['error' => true]);
})->where('any', '^(?!api).*$');