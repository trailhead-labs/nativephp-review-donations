<?php

$donations = require __DIR__.'/donations.php';

$agents = array_keys($donations['agents']);
$tracks = array_keys($donations['tracks']);
$levels = array_keys($donations['levels']);

$basePath = trim(parse_url((string) env('APP_URL'), PHP_URL_PATH) ?? '', '/');

return [

    /*
    |--------------------------------------------------------------------------
    | Base Path
    |--------------------------------------------------------------------------
    |
    | The path GitHub Pages serves the site from, taken from APP_URL. The
    | routes are prefixed with it, and the export mirrors it in dist.
    |
    */

    'base_path' => $basePath,

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Every page and prompt file, listed rather than crawled. The prompts
    | are only ever fetched by JavaScript, so a crawler would never find
    | them. Each path lives under the base path, like the routes do.
    |
    */

    'crawl' => false,

    'paths' => array_map(fn (string $path): string => trim("$basePath/$path", '/') ?: '/', [
        '',
        'how-it-works',
        'setup',
        'maintainers',
        'faq',
        ...array_map(fn (string $track): string => "tracks/$track", $tracks),
        ...array_map(fn (string $agent): string => "prompts/$agent/self-check.txt", $agents),
        ...collect($agents)->crossJoin($tracks, $levels)->map(fn (array $prompt): string => 'prompts/'.implode('/', $prompt).'.txt')->all(),
    ]),

    'use_streaming' => false,

    /*
    |--------------------------------------------------------------------------
    | Files
    |--------------------------------------------------------------------------
    |
    | The public folder is copied next to the pages, for the built assets.
    | Server files and local dev leftovers are kept out of the build.
    |
    */

    'include_files' => [
        'public' => $basePath,
    ],

    'exclude_file_patterns' => [
        '/\.php$/',
        '/public\/hot$/',
        '/fonts-manifest\.dev\.json$/',
    ],

    'clean_before_export' => true,

    'disk' => null,

    'before' => [],

    'after' => [],

];
