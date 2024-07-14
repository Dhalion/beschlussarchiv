<div>
    <h2>Gremien</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        @can('create', App\Models\Council::class)
            <a href="{{ route('admin.councils.create') }}" wire:navigate>Neues Gremium anlegen</a>
        @endcan
        <label for="search">Suche:</label>
        <input type="text" wire:model.live="search" placeholder="Suche" id="search">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Beschlüsse</th>
                    <th>Kategorien</th>
                    <th>Antragssteller*innen</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($councils as $council)
                    @php
                        /** @var App\Models\Council $council */
                    @endphp
                    <tr>
                        <td>{{ explode('-', $council->id)[4] }}</td>
                        <td>{{ $council->name }}</td>
                        <td>{{ $council->resolutions->count() }}</td>
                        <td>{{ $council->categories->count() }}</td>
                        <td>{{ $council->applicants->count() }}</td>
                        <td>
                            <a href="#">Bearbeiten</a>
                        </td>
                        <td>
                            <a href="#" wire:click="deleteCouncil('{{ $council->id }}')"
                                wire:confirm="Sind Sie sicher, dass Sie das Gremium löschen möchten?">Löschen</a>
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
                <option>20</option </select>
                {{ $councils->links() }}
        </div>

    </div>
</div>
