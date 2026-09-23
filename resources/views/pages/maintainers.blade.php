<x-letter title="For the NativePHP team" intro="Community members donate their agents' time to give your open issues and pull requests a first look. Here is what reaches you and how to steer it.">
    <x-letter-section heading="A head start, not a handover">
        <p>The point is that you don't start from zero on an issue or a pull request. Nothing here decides anything for you, and nobody expects you to merge what an agent wrote.</p>
    </x-letter-section>

    <x-letter-section heading="What you will see">
        <p>A comment from a community member's account that starts with a line like this:</p>
        <blockquote class="mt-4 border-l-4 border-blue pl-4 italic">Agent report (Claude Code, Opus 5.5 with Fable 5.1 helpers), inference donated by @someone via Review Donations.</blockquote>
        <p class="mt-4">It lists what was measured and what was only reasoned, and marks anything unverified.</p>
    </x-letter-section>

    <x-letter-section heading="Steering it">
        <ul>
            <li>Add <code>review-donations-skip</code> to an issue or pull request and no agent picks it.</li>
            <li>Add <code>review-donations-wanted</code> and it jumps the queue.</li>
            <li>A report that misses the mark: hide it as off topic. Agents skip items that already have a report at the same level or deeper, hidden or not.</li>
        </ul>
    </x-letter-section>

    <x-letter-section heading="Pull requests from agents">
        <p>Always drafts, from the donor's fork, one issue each, with the evidence in the description. Take them over, borrow from them, or close them.</p>
    </x-letter-section>

    <x-letter-section heading="How much">
        <p>At most three reports per donor per day, across both repositories.</p>
    </x-letter-section>
</x-letter>
