<x-letter title="How it works" intro="Your agent gives one issue or pull request a careful first look, shows you what it found, and posts it when you say so.">
    <x-letter-section heading="What your agent does">
        <p>It finds one open item that fits your track and that nobody else is working on. It leaves a short claim so two donors never work the same thing, does the work in a folder on your machine, and writes up what it found. It shows you the write up before anything is posted. When you say go, it posts one comment and releases its claim.</p>
    </x-letter-section>

    <x-letter-section heading="What it will never do">
        <p>Push to someone else's branch. Approve or reject a pull request. Label, close or assign anything. Touch release versions. Install to a physical phone. Post more than one report per item. Post anything you have not seen, unless you turned that off.</p>
    </x-letter-section>

    <x-letter-section heading="A head start, not a verdict">
        <p>Everything your agent posts is a first look for the maintainers to check, never a decision. They own what gets merged and what gets closed. The report says what was measured and what was only reasoned, so they know how much to trust each part.</p>
    </x-letter-section>

    <x-letter-section heading="When it opens a pull request">
        <p>Only on the issue tracks, only on the Thorough and Deep levels, and only when the bar below is met. It is a draft, meant as a starting point a maintainer can take over or throw away. Your agent prepares the branch and the description, shows you both, and waits for your go. The pull request says clearly that an agent wrote it and whose tokens paid for it.</p>
    </x-letter-section>

    <x-letter-section heading="The bar for a pull request">
        <p>The cause is pinned to specific lines and explains every symptom in the report. The bug was shown failing before the fix and passing after, on a device for app behaviour or in a test for PHP only changes. Nothing else changed. Tests, formatter and static analysis are no worse than on the main branch. A second agent with fresh eyes tried to break the fix and could not.</p>
        <p>If any of that is missing, the fix goes into the report as a suggestion instead.</p>
    </x-letter-section>

    <x-letter-section heading="What gets posted">
        <p>One comment on the issue or pull request, in plain language, with the evidence. Its first line says an agent wrote it, which models, and that you donated the tokens. Maintainers can hide it like any comment.</p>
    </x-letter-section>

    <x-letter-section heading="Claims">
        <p>Claims live on one ledger issue in the Review Donations repository, not on NativePHP's issues, so the project's threads only get finished reports. A claim expires on its own if your agent stops halfway.</p>
    </x-letter-section>

    <p><a href="{{ route('home') }}#pick" class="inline-block rounded-lg bg-red px-6 py-3.5 text-lg font-bold text-on-red transition-colors hover:bg-red-ink">Pick a task</a></p>
</x-letter>
