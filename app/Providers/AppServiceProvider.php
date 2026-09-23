<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * On a subpath the routes carry that path themselves, so links are
     * generated from the bare host. That keeps them identical in the
     * console and inside the requests the static export makes.
     */
    public function boot(): void
    {
        if (config('export.base_path') === '') {
            return;
        }

        ['scheme' => $scheme, 'host' => $host] = parse_url(config('app.url'));

        URL::forceRootUrl("$scheme://$host");
    }
}
