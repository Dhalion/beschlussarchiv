<div>
    <h2>Gremium anlegen</h2>

    <form wire:submit.prevent="createCouncil">
        <div>
            <label for="name">Name:</label>
            <input type="text" wire:model="name" id="name">
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <button type="submit">Speichern</button>
        </div>
    </form>
</div>
