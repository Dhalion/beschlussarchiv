<div>
    <h2>Antragsteller*innen</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <button wire:click="createResolution">Neuer Antragsteller*in</button>
        <label for="search">Suche:</label>
        <input type="text" wire:model.live="search" placeholder="Suche" id="search">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gremium</th>
                    <th>Name</th>
                    <th>Beschlüsse</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $applicant)
                    @php
                        /** @var App\Models\Applicant $applicant */
                    @endphp
                    <tr>
                        <td>{{ explode('-', $applicant->id)[4] }}</td>
                        <td>{{ $applicant->council->name }}</td>
                        <td>{{ $applicant->name }}</td>
                        <td>{{ $applicant->resolutions->count() }}</td>
                        <td>
                            <a href="#" wire:click="deleteApplicant('{{ $applicant->id }}')"
                                wire:confirm="Sind Sie sicher, dass Sie den Antragsteller*in löschen möchten?">Löschen</a>
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
            {{ $applicants->links() }}
        </div>
    </div>
</div>
