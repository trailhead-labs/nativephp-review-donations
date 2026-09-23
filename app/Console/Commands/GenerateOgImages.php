<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

#[Signature('og:generate {card?* : Only render these cards}')]
#[Description('Render the share cards in resources/views/og to public/og')]
class GenerateOgImages extends Command
{
    /**
     * Screenshot each card with headless Chrome. The site has to be
     * served at APP_URL while this runs, with its assets built.
     */
    public function handle(): int
    {
        $cards = $this->argument('card') ?: array_keys(config('og.cards'));

        File::ensureDirectoryExists(public_path('og'));

        foreach ($cards as $card) {
            $result = Process::run([
                config('og.chrome'),
                '--headless=new',
                '--hide-scrollbars',
                '--ignore-certificate-errors',
                '--force-device-scale-factor=1',
                '--window-size=1200,630',
                '--virtual-time-budget=5000',
                '--screenshot='.public_path("og/$card.png"),
                route('og.card', $card),
            ]);

            if ($result->failed()) {
                $this->components->error("Could not render [$card]: ".trim($result->errorOutput()));

                return self::FAILURE;
            }

            $this->components->twoColumnDetail($card, "public/og/$card.png");
        }

        return self::SUCCESS;
    }
}
