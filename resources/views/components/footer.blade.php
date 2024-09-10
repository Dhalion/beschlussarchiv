<footer class="bg-primary text-white flex items-center flex-col mt-10 p-5 w-screen">
    <span>
        Beschlusswiki by <a href="https://rotes.team">Rotes Team</a>
    </span>
    <div>
        <span>Commit: {{ config('version.string') }}</span>
        @env(['staging', 'local'])
        <span>{{ config('app.env') }}</span>
        <span>{{ 'Laravel ' . app()->version() }}</span>
        <span>{{ 'PHP ' . PHP_VERSION }}</span>
        @endenv
    </div>
</footer>
