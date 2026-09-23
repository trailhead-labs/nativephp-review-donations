<x-letter og="faq" title="Questions">
    @foreach ([
        'What does it cost me?' => 'Every prompt shows its models and a rough token range before you copy. Quick levels are a small slice of a subscription window. Deep device runs can use most of a day\'s allowance.',
        'Can I cap it?' => 'Pick a level, or use Adaptive with a ceiling. It sizes the work to the item and never goes over.',
        'Is it safe to run on my machine?' => 'Your agent works in one folder it creates. It clones public repositories, installs their PHP dependencies, and on device tracks builds apps and starts an emulator or simulator. It asks before installing anything system wide.',
        'Whose account posts?' => 'Yours, through gh. That is what makes the credit yours.',
        'Why not a bot?' => 'A bot needs someone to pay for the tokens. That is the part you are giving.',
        'Which agents work?' => 'Claude Code and Codex get prompts tuned for how they start helpers. Anything else gets a version that runs every step in one session.',
    ] as $question => $answer)
        <x-letter-section :heading="$question">
            <p>{{ $answer }}</p>
        </x-letter-section>
    @endforeach
</x-letter>
