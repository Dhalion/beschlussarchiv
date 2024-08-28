<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Attributes\On;
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
        ['key' => 'council.name', 'label' => 'Gremium'],
        ['key' => 'tag', 'label' => 'Tag'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'resolutions_count', 'label' => 'Beschlüsse'],
        ['key' => 'actions', 'label' => 'Aktionen'],
    ];

    public $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('success', 'Category deleted successfully.');
    }


    #[On('councilIdUpdated')]
    public function render()
    {
        $categories = $this->search == ''
            ? Category::where("council_id", session("councilId"))
            ->withCount("resolutions")
            ->with(['council:id,name'])
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage)
            : Category::search($this->search)->where("council_id", session("councilId"))
            ->withCount("resolutions")
            ->with(['council:id,name'])
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
        return view('livewire.admin.categories.index', [
            'categories' => $categories
        ])->layout('layouts.admin');
    }
}
