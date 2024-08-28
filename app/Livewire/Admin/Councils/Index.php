<?php

namespace App\Livewire\Admin\Councils;

use App\Models\Council;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $perPage = 10;

    #[Url(except: '')]
    public $search = '';

    public $headers = [
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'resolutions_count', 'label' => 'Beschlüsse'],
        ['key' => 'categories_count', 'label' => 'Kategorien'],
        ['key' => 'applicants_count', 'label' => 'Antragsteller*innen'],
        ['key' => 'actions', 'label' => 'Aktionen'],
    ];

    public $sortBy = ['column' => 'name', 'direction' => 'asc'];


    public function deleteCouncil($id)
    {
        Council::findOrFail($id)->delete();
        session()->flash('success', 'Council deleted successfully.');
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
