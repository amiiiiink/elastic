<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-log', function () {
    logger()->error('fucking error', [
        'user_id' => 42,
        'ip' => request()->ip(),
        'url' => request()->fullUrl(),
    ]);

    return 'Logged to Elasticsearch!';
});

