<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class PromptController extends Controller
{
    /**
     * Render one track and level's prompt for the given agent.
     */
    public function show(string $agent, string $track, string $level): Response
    {
        $prompt = config("donations.prompts.$track.$level");

        return $this->render("prompts.$track.$level", $agent, [
            'track' => $track,
            'level' => $level,
            'tokens' => $prompt['tokens'],
            'time' => $prompt['time'],
        ]);
    }

    /**
     * Render the standalone setup check for the given agent.
     */
    public function selfCheck(string $agent): Response
    {
        return $this->render('prompts.self-check', $agent, [
            'track' => 'any',
            'level' => 'self-check',
            'tokens' => config('donations.self_check.tokens'),
            'time' => config('donations.self_check.time'),
        ]);
    }

    /**
     * Render a prompt view as plain text. Donor placeholders stay
     * in the text, the picker fills them in before it copies.
     *
     * @param  array{track: string, level: string, tokens: string, time: string}  $data
     */
    protected function render(string $view, string $agent, array $data): Response
    {
        $text = view($view, [
            ...$data,
            'agent' => $agent,
            'models' => collect(config('donations.roles'))->map(fn (array $role): string => $role['models'][$agent])->all(),
            'siteUrl' => url('/'),
            'ledger' => config('donations.ledger'),
        ])->render();

        $text = trim(preg_replace("/\n{3,}/", "\n\n", $text))."\n";

        return response($text)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
