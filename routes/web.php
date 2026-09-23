<?php

use App\Http\Controllers\PromptController;
use Illuminate\Support\Facades\Route;

$agents = array_keys(config('donations.agents'));
$tracks = array_keys(config('donations.tracks'));
$levels = array_keys(config('donations.levels'));

/*
 * GitHub Pages serves this site from a subpath, which the export
 * puts in APP_URL. Prefixing the routes keeps every link and page
 * under it. Locally APP_URL has no path, so there is no prefix.
 */
Route::prefix(config('export.base_path'))->group(function () use ($agents, $tracks, $levels) {
    Route::view('/', 'pages.home')->name('home');

    Route::view('/tracks/{track}', 'pages.track')
        ->whereIn('track', $tracks)
        ->name('tracks.show');

    Route::view('/how-it-works', 'pages.how-it-works')->name('how-it-works');
    Route::view('/setup', 'pages.setup')->name('setup');
    Route::view('/maintainers', 'pages.maintainers')->name('maintainers');
    Route::view('/faq', 'pages.faq')->name('faq');

    Route::get('/prompts/{agent}/self-check.txt', [PromptController::class, 'selfCheck'])
        ->whereIn('agent', $agents)
        ->name('prompts.self-check');

    Route::get('/prompts/{agent}/{track}/{level}.txt', [PromptController::class, 'show'])
        ->whereIn('agent', $agents)
        ->whereIn('track', $tracks)
        ->whereIn('level', $levels)
        ->name('prompts.show');
});

/*
 * Share card templates, rendered to PNG by `php artisan og:generate`.
 * They exist for local rendering only and never reach the export.
 */
if (! app()->isProduction()) {
    Route::view('/og/{card}', 'og.card')
        ->whereIn('card', array_keys(config('og.cards')))
        ->name('og.card');
}
