<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn()=> response()->json([
    'Author' => 'Luiz Felipe',
    'Project' => 'Teste Backend'
]));
