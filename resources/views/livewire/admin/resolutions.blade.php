<div>
    <h2>Beschlüsse</h2>

    <div>
        <button wire:click="createResolution">Neuer Beschluss</button>
        <input type="text" wire:model.live="search" placeholder="Suche">
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
                            <a wire:click="viewResolution({{ $resolution->id }})">Ansehen</a>
                            <a wire:click="editResolution({{ $resolution->id }})">Bearbeiten</a>
                            <a wire:click="deleteResolution({{ $resolution->id }})">Löschen</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="table-footer-group">
            <select wire:model.live="perPage">
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>20</option>
            </select>
            {{ $resolutions->links() }}
        </div>

        <div>
        </div>
    </div>
