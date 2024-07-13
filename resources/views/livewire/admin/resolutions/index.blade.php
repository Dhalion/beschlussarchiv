<div>
    <h2>Beschlüsse</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <a href="{{ route('admin.resolutions.create') }}" wire:navigate>Neuen Beschluss anlegen</a>
        <label for="search">Suche:</label>
        <input type="text" wire:model.live="search" placeholder="Suche" id="search">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gremium</th>
                    <th>Tag</th>
                    <th>Titel</th>
                    <th>Erstellt am</th>
                    <th>Optionen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resolutions as $resolution)
                    @php
                        /** @var App\Models\Resolution $resolution */
                    @endphp
                    <tr>
                        <td>{{ explode('-', $resolution->id)[4] }}</td>
                        <td>{{ $resolution->council->name }}</td>
                        <td>{{ "$resolution->year-$resolution->tag" }}</td>
                        <td>{{ $resolution->title }}</td>
                        <td>{{ $resolution->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('resolution', $resolution->id) }}" wire:navigate>Anzeigen</a>
                            <a href="{{ route('admin.resolutions.edit', $resolution->id) }}" wire:navigate>Bearbeiten</a>
                            <a href="#" wire:click="deleteResolution('{{ $resolution->id }}')"
                                wire:confirm="Sind Sie sicher, dass Sie den Beschluss löschen möchten?">Löschen</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="table-footer-group">
            <label for="perPage">Einträge pro Seite:</label>
            <select wire:model.live="perPage" id="perPage">
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>20</option>
            </select>
            {{ $resolutions->links() }}
        </div>
    </div>
</div>
