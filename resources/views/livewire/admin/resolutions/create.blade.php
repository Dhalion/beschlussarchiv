<div>
    <h2>Neuen Beschluss anlegen</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="store">
        <label for="council_id">Gremium:</label>
        <select wire:model="council_id" id="council_id">
            <option value="">Bitte wählen</option>
            @foreach ($councils as $council)
                <option value="{{ $council->id }}">{{ $council->name }}</option>
            @endforeach
        </select>
        @error('council_id')
            <span>{{ $message }}</span>
        @enderror

        <label for="category_id">Kategorie:</label>
        <select wire:model="category_id" id="category_id">
            <option value="">Bitte wählen</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <span>{{ $message }}</span>
        @enderror

        <label for="year">Jahr:</label>
        <input type="number" wire:model="year" id="year">
        @error('year')
            <span>{{ $message }}</span>
        @enderror

        <label for="tag">Tag:</label>
        <input type="text" wire:model="tag" id="tag">
        @error('tag')
            <span>{{ $message }}</span>
        @enderror

        <label for="title">Titel:</label>
        <input type="text" wire:model="title" id="title">
        @error('title')
            <span>{{ $message }}</span>
        @enderror

        <label for="text">Inhalt:</label>
        <textarea wire:model="text" id="text"></textarea>
        @error('text')
            <span>{{ $message }}</span>
        @enderror

        <button type="submit">Speichern</button>
    </form>
</div>
