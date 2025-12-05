<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return [
        'name' => $user->name,
        'email' => $user->email,
        'image_url' => method_exists($user, 'getImageUrl') ? $user->getImageUrl() : null,
    ];
});
