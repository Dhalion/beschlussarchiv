<div>
    @php
        /** @var App\Models\Resolution $resolution */
    @endphp
    <div class="resolution-head">
        <div>
            <h2>
                {{ $resolution->tag }}
            </h2>
            <h3>
                {{ $resolution->year }}
            </h3>
        </div>
        <h2>
            {{ $resolution->title }}
        </h2>
    </div>
    <div class="resolution-meta">
        <span>
            Kategorie:
            <a href="/category/{{ $resolution->category_id }}" wire:navigate.hover>
                {{ $resolution->category->name }}
            </a>
        </span>

    </div>
    <div class="resolution-navigation">

    </div>
    <div class="resolution-content">
        {{ $resolution->text }}
    </div>
</div>
