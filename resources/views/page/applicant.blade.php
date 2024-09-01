@php
    /** @var App\Models\Applicant $applicant */
    /** @var App\Models\Resolution $resolution */
@endphp

@extends('layouts.app')

@section('title', $applicant->name . ' - Beschlussarchiv')


@section('content')
    <div class="flex flex-col sm:w-3/4 mx-3 sm:mx-auto mt-5 text-black">
        @php
            $resolutionsCount = $applicant->resolutions->count();
        @endphp
        <div id="applicant-header" class="flex justify-start mb-5">
            <img src="{{ asset('/images/work-in-progress.png') }}" class="h-14 mr-2 sm:mr-5 dark:invert p-1"
                alt="{{ $applicant->name }}" />
            <div>
                <h2 class="text-gray-700 dark:text-gray-300 font-bold text-2xl">Beschlüsse von: {{ $applicant->name }}</h2>
                <span class="text-gray-500 dark:text-gray-400 text-sm font-light">
                    {{ $resolutionsCount }}
                    {{ $resolutionsCount == 1 ? 'Beschluss' : 'Beschlüsse' }}
                </span>
            </div>
        </div>

        <div id="applicant-resolutions" class="flex flex-col gap-y-3">

            @foreach ($applicant->resolutions as $resolution)
                @include('components.resolution-card', ['resolution' => $resolution])
            @endforeach
        </div>

    </div>
@endsection
