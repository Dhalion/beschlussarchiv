<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
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

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('success', 'Category deleted successfully.');
    }


    public function render()
    {
        $categories = $this->search == ''
            ? Category::paginate($this->perPage)
            : Category::search($this->search)->paginate($this->perPage);
        return view('livewire.admin.categories.index', [
            'categories' => $categories
        ])->layout('layouts.admin');
    }
}
