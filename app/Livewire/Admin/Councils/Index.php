<?php

namespace App\Livewire\Admin\Councils;

use App\Models\Council;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
    use WithPagination, Toast;

    #[Url(except: '')]
    public $perPage = 10;

    #[Url(except: '')]
    public $search = '';

    public string $name, $shortName = '';

    public $headers = [
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'resolutions_count', 'label' => 'Beschlüsse'],
        ['key' => 'categories_count', 'label' => 'Kategorien'],
        ['key' => 'applicants_count', 'label' => 'Antragsteller*innen'],
        ['key' => 'actions', 'label' => 'Aktionen'],
    ];

    public $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public bool $showCreateModal, $showDeleteModal = false;
    public $councilToDelete;

    public function openDeleteModal(string $councilId)
    {
        $this->councilToDelete = Council::withCount("applicants")
            ->withCount("categories")
            ->withCount("resolutions")
            ->findOrFail($councilId);
        $this->showDeleteModal = true;
    }

    public function deleteCouncil()
    {
        $this->councilToDelete->delete();
        $this->showDeleteModal = false;
        $this->toast(
            title: 'Gremium gelöscht',
            description: 'Das Gremium wurde erfolgreich gelöscht.',
            type: 'success',
            icon: 'o-check',
            position: 'top-right'
        );
    }

    public function createCouncil()
    {
        $this->validate([
            'name' => 'required|string',
            'shortName' => 'required|string|uppercase|alpha',
        ]);
        $council = new Council(
            [
                'name' => $this->name,
                'shortName' => $this->shortName,
            ]
        );
        $council->save();

        $this->showCreateModal = false;
        $this->toast(
            title: 'Gremium erstellt',
            description: 'Das Gremium wurde erfolgreich erstellt.',
            type: 'success',
            icon: 'o-check',
            position: 'top-right'
        );
    }

    public function render()
    {
        return view('livewire.admin.councils.index', [
            'councils' => Council::withCount("applicants")
                ->withCount("categories")
                ->withCount("resolutions")
                ->orderBy(...array_values($this->sortBy))
                ->paginate($this->perPage)
        ])->layout('layouts.admin');
    }
}
