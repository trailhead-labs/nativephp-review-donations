<?php

it('renders every page', function (string $uri, string $heading) {
    $this->get($uri)->assertOk()->assertSee($heading);
})->with([
    'home' => ['/', 'Put your spare AI tokens to work on NativePHP'],
    'how it works' => ['/how-it-works', 'A head start, not a verdict'],
    'setup' => ['/setup', 'Set up your machine'],
    'maintainers' => ['/maintainers', 'For the NativePHP team'],
    'faq' => ['/faq', 'Why not a bot?'],
]);

it('renders a page per track', function (string $track) {
    $this->get("/tracks/$track")
        ->assertOk()
        ->assertSee(config("donations.tracks.$track.name"));
})->with(['issue-reason', 'issue-prove', 'pr-reason', 'pr-prove']);

it('returns not found for an unknown track', function () {
    $this->get('/tracks/fix-everything')->assertNotFound();
});
