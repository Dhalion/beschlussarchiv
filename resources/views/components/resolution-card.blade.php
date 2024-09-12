@php
    /* @var App\Models\Resolution $resolution */
@endphp
<a id="resolution-card"
    class="w-full flex mx-auto bg-white dark:bg-slate-700 dark:shadow-gray-800 rounded-xl shadow-md hover:shadow-xl overflow-hidden p-3"
    href="/resolution/{{ $resolution->getResolutionCode() }}" wire:navigate.hover="resolution">
    <span
        class="xl:w-1/12 md:w-2/12 w-3/12 mr-3 flex flex-col items-center justify-center text-2xl xl:text-3xl text-slate-700 dark:text-slate-200">
        {{ strtoupper($resolution->tag) }}
    </span>
    </span>
    <div class="flex flex-col w-full items-start">
        <span class="text-xs text-slate-500 dark:text-slate-400">{{ $resolution->year }}</span>
        <span class="text-slate-800 dark:text-slate-200"> {{ $resolution->title }} </span>
    </div>
</a>
