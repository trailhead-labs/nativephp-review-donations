<?php

it('renders every prompt as self contained plain text', function (string $agent, string $track, string $level) {
    $response = $this->get("/prompts/$agent/$track/$level.txt")
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');

    expect($response->getContent())
        ->toContain("TRACK             = $track", "LEVEL             = $level", '{{donor.handle}}')
        ->not->toContain('@include', '@if', '@endif', '{{ $', '{{>', ':::', '[Name]', '&#');
})
    ->with(['claude', 'codex', 'other'])
    ->with(['issue-reason', 'issue-prove', 'pr-reason', 'pr-prove'])
    ->with(['quick', 'thorough', 'deep', 'adaptive']);

it('keeps only the chosen agent\'s variant lines', function () {
    $claude = $this->get('/prompts/claude/pr-reason/deep.txt')->getContent();
    $codex = $this->get('/prompts/codex/pr-reason/deep.txt')->getContent();

    expect($claude)->toContain('Use the Agent tool', 'Fable 5.1')->not->toContain('codex exec')
        ->and($codex)->toContain('codex exec')->not->toContain('Use the Agent tool', 'Fable 5.1');
});

it('inlines each level\'s work into the adaptive prompt', function () {
    expect($this->get('/prompts/claude/issue-reason/adaptive.txt')->getContent())
        ->toContain('### If you chose Quick', 'This level is one focused pass by you alone');
});

it('renders the self check for every agent', function (string $agent) {
    expect($this->get("/prompts/$agent/self-check.txt")->assertOk()->getContent())
        ->toContain('{{donor.tracks}}', 'git --version')
        ->not->toContain('@include', '{{ $');
})->with(['claude', 'codex', 'other']);

it('returns not found for an unknown agent or level', function (string $uri) {
    $this->get($uri)->assertNotFound();
})->with(['/prompts/gemini/pr-reason/quick.txt', '/prompts/claude/pr-reason/extreme.txt']);

it('claims on the ledger and spreads a wave of donors across candidates', function () {
    expect($this->get('/prompts/claude/issue-reason/quick.txt')->getContent())
        ->toContain('LEDGER            = trailhead-labs/nativephp-review-donations#1')
        ->toContain('pick one at random from the first five')
        ->toContain("grep -o '<!-- review-donations:report")
        ->not->toContain('[name]');
});
