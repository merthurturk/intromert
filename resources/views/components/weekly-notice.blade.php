@props(['showMoreLink' => true])
<x-notice>
    A glance at the highlights and learnings from a week in my journey.
    @if ($showMoreLink)
        Curious for more? Browse through my <a href="/entries/weekly">previous weekly updates</a>.
    @endif
</x-notice>
