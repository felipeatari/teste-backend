<?php

use App\Http\Controllers\SearchCepController;
use Illuminate\Support\Facades\Route;

Route::get('/search/local/{ceps}', [SearchCepController::class, 'search']);
