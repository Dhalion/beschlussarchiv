<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Models\Council;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
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

    public $headers = [
        ['key' => 'council.name', 'label' => 'Gremium'],
        ['key' => 'tag', 'label' => 'Tag'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'resolutions_count', 'label' => 'Beschlüsse'],
        ['key' => 'actions', 'label' => 'Aktionen'],
    ];

    public $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public bool $showCreateModal, $showDeleteModal = false;
    public string $name, $tag = '';

    public ?Category $categoryToDelete = null;

    public string $categoryToMoveResolutionsTo = '';
    public Collection $possibleDestinationCategories;

    public function initDeletion(string $categoryId)
    {
        $category = Category::withCount("resolutions")->findOrFail($categoryId);
        if ($category->resolutions_count > 0) {
            $this->possibleDestinationCategories = Category::where("council_id", session("councilId"))
                ->where("id", "<>", $categoryId)
                ->get();
        }

        $this->categoryToDelete = $category;
        $this->showDeleteModal = true;
    }

    public function deleteCategory($id)
    {
        if ($this->categoryToMoveResolutionsTo) {
            $category = Category::findOrFail($id);
            $category->resolutions()->update([
                'category_id' => $this->categoryToMoveResolutionsTo
            ]);
        }
        Category::findOrFail($id)->delete();
        $this->toast(
            title: 'Kategorie gelöscht',
            description: 'Die Kategorie wurde erfolgreich gelöscht.',
            type: 'success',
            position: 'top-right',
            icon: 'o-check-circle',
            timeout: 3000
        );
        $this->showDeleteModal = false;
    }

    public function storeCategory()
    {
        $councilId = session("councilId");
        $this->validate([
            'name' => 'required|string',
            'tag' => 'required|string',
        ]);
        Category::create([
            'name' => $this->name,
            'tag' => $this->tag,
            'council_id' => $councilId,
        ]);
        $this->showCreateModal = false;
        $this->toast(
            title: 'Kateogrie erstellt',
            description: 'Die Kategorie wurde erfolgreich erstellt.',
            type: 'success',
            position: 'top-right',
            icon: 'o-check-circle',
            timeout: 3000
        );
    }

    #[Computed]
    public function getCouncilName(): string
    {
        $councilId = session("councilId");
        return $councilId ? Council::findOrFail($councilId)->name : 'Nicht gefunden';
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
