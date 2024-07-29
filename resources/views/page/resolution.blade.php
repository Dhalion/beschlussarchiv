@php
    /** @var App\Models\Resolution $resolution */
@endphp

@extends('layouts.app')

@section('title', strtoupper($resolution->tag) . "-$resolution->year Beschlusswiki")

@section('content')
    <div id="resolution-page" class="flex flex-col w-full md:w-9/12 lg:w-8/12 xl:w-7/12 xl:mx-auto shadow">

        {{-- ###        YEAR-TAG & TITLE HEADER        ### --}}
        <div id="resolution-head" class="flex justify-center text-black dark:text-slate-200 w-full flex-grow">
            <div
                class="bg-hellrosa-200 dark:bg-hellrosa-900 text-beere-600
             dark:text-beere-200 flex justify-center justify-self-center
              place-items-center w-full">
                <div class="flex flex-col items-center xl:p-10 p-5">
                    <span class="font-black xl:text-8xl text-4xl xl:pb-4">{{ strtoupper($resolution->tag) }}</span>
                    <span class="font-black xl:text-6xl text-2xl">{{ $resolution->year }}</span>
                </div>
                <div class="w-3/4 xl:p-1 font-bold xl:text-4xl text-lg xl:line-clamp-3 xl:text-clip xl:pr-4">
                    {{ $resolution->title }}
                </div>
            </div>
        </div>

        {{-- ###        RESOLUTION META        ### --}}
        <div id="resolution-meta" class="bg-beere-600 dark:bg-beere-200 flex justify-between items-center p-1 px-3 h-6">
            <div class="text-xs font-sans text-white dark:text-hellrosa-900 antialiased" v-if="category">
                <a href="/category/{{ $resolution->category->id }}" wire:navigate.hover>
                    {{ $resolution->category->name }}
                </a>
            </div>
            <div class="text-xs font-sans text-white dark:text-hellrosa-900 antialiased" v-if="applicants">
                @foreach ($resolution->applicants as $applicant)
                    <a href="/applicant/{{ $applicant->id }}" wire:navigate.hover>
                        {{ $applicant->name }}
                    </a>
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </div>
        </div>

        {{-- ###        RESOLUTION NAVIGATION        ### --}}
        <div id="resolution-navigation" class="flex flex-row justify-between m-2 px-4 pt-2 text-beere-400">
            <a class="flex items-center gap-x-1">
                <x-icon name="o-backward" class="w-6" />
                <span>
                    Vorheriger Beschluss
                </span>
            </a>
            <a wire:navigate href="{{ url()->previous() }}" class="hover:cursor-pointer flex items-center gap-x-1">
                <x-icon name="o-arrow-up-on-square" class="w-6" />
                Zurück zur Übersicht
            </a>
            <a wire:navigate href="/category/{{ $resolution->category->id }}" class="flex items-center gap-x-1">
                <x-icon name="o-queue-list" class="w-6" />
                Zurück zur Kategorie
            </a>
            <a class="flex items-center gap-x-1">
                Nächster Beschluss
                <x-icon name="o-forward" class="w-6" />
            </a>
        </div>

        {{-- ###        RESOLUTION TEXT        ### --}}
        <div class="leading-6 antialiased sm:w-3/4 w-5/6 mx-auto pb-10 mt-3">
            <span class="prose text-base text-gray-800 dark:text-slate-400">
                {!! $resolution->text !!}
            </span>
        </div>

    @endsection
