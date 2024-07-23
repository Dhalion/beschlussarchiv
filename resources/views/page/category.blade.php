@php
    /** @var App\Models\Category $category */
    /** @var App\Models\Resolution $resolution */
@endphp

@extends('layouts.app')

@section('title', $category->name . ' - Beschlusswiki')

@section('content')
    <div>
        <h2>Kategorie: {{ $category->name }}</h2>
        @foreach ($category->resolutions as $resolution)
            <a href="/resolution/{{ $resolution->id }}" wire:navigate.hover="resolution">
                <h4>
                    {{ $resolution->title }}
                </h4>
            </a>
        @endforeach
        <div>

        </div>
    </div>
@endsection
