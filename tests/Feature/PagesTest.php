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

it('renders every path the static export writes', function () {
    foreach (config('export.paths') as $path) {
        $this->get($path)->assertOk();
    }

    expect(config('export.paths'))->toHaveCount(5 + 4 + 3 + 48);
});

it('gives every page a share card that exists', function (string $uri, string $card) {
    $this->get($uri)
        ->assertSee('<meta property="og:image" content="'.asset("og/$card.png").'?v='.substr(md5_file(public_path("og/$card.png")), 0, 8).'">', false)
        ->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
        ->assertSee('<meta property="og:url" content="'.rtrim(url($uri), '/').'/">', false)
        ->assertDontSee('<3 stamp', false);

    expect(public_path("og/$card.png"))->toBeFile();
})->with([
    'home' => ['/', 'home'],
    'how it works' => ['/how-it-works', 'how-it-works'],
    'setup' => ['/setup', 'setup'],
    'maintainers' => ['/maintainers', 'maintainers'],
    'faq' => ['/faq', 'faq'],
    'a track' => ['/tracks/pr-prove', 'tracks-pr-prove'],
]);

it('renders every share card template', function () {
    foreach (array_keys(config('og.cards')) as $card) {
        $this->get("/og/$card")->assertOk()->assertSee(config("og.cards.$card.title"));

        expect(public_path("og/$card.png"))->toBeFile();
    }
});

it('links to the repository for contributors', function () {
    $this->get('/')->assertSee('href="https://github.com/trailhead-labs/nativephp-review-donations"', false);
});
