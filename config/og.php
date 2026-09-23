<?php

$tracks = (require __DIR__.'/donations.php')['tracks'];

return [

    /*
    |--------------------------------------------------------------------------
    | Share Cards
    |--------------------------------------------------------------------------
    |
    | One card per page, shown when a link is shared. Each is a Blade view
    | rendered to public/og/{card}.png by `php artisan og:generate`. Add a
    | card here whenever a page is added, and run the command again.
    |
    */

    'cards' => [
        'home' => [
            'title' => 'Put your spare AI tokens to work on NativePHP',
            'line' => 'Copy one prompt. Your agent gives a real issue or pull request a first look.',
        ],
        'how-it-works' => [
            'title' => 'How it works',
            'line' => 'One careful first look, shown to you before anything is posted.',
        ],
        'setup' => [
            'title' => 'Set up your machine',
            'line' => 'What your agent needs to read the code, or to run it on a device.',
        ],
        'maintainers' => [
            'title' => 'For the NativePHP team',
            'line' => 'A head start on your issues and pull requests, never a verdict.',
        ],
        'faq' => [
            'title' => 'Questions',
            'line' => 'What it costs, whose account posts, and why not a bot.',
        ],
        ...collect($tracks)->mapWithKeys(fn (array $track, string $key): array => ["tracks-$key" => [
            'title' => $track['name'],
            'line' => $track['blurb'],
        ]])->all(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Chrome
    |--------------------------------------------------------------------------
    |
    | The browser that renders the cards. Any Chrome or Chromium binary
    | that supports headless screenshots will do.
    |
    */

    'chrome' => env('CHROME_PATH', '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome'),

];
