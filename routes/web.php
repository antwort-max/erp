<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/ecommerce.php';

Route::get('/s', function () {
    return view('welcome');
});
