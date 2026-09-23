<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
 * A static site has no sessions, cookies or forms, so the routes
 * skip the web middleware group. That also means no app key and
 * no database are needed to run it, or to export it to HTML.
 */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(using: fn () => Route::group([], base_path('routes/web.php')))
    ->withMiddleware()
    ->withExceptions()
    ->create();
