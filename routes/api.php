<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/ping', function (Request $request) {
    return response()->json(['message' => 'pong']);
});