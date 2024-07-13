<div>
    <h2>Kategorien</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <button wire:click="createCategory">Neue Kategorie</button>
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
                @foreach ($categories as $category)
                    @php
                        /** @var App\Models\Category $category */
                    @endphp
                    <tr>
                        <td>{{ explode('-', $category->id)[4] }}</td>
                        <td>{{ $category->council->name }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->resolutions->count() }}</td>
                        <td>
                            <a href="#" wire:click="deleteCategory('{{ $category->id }}')"
                                wire:confirm="Sind Sie sicher, dass Sie die Kategorie löschen möchten?">Löschen</a>
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
            {{ $categories->links() }}
        </div>

        <div>
        </div>
    </div>
</div>
