<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryPage extends Component
{

    public $category = null;

    public function mount(string $parameter)
    {
        if (uuid_is_valid($parameter)) {
            $this->category = Category::findOrFail($parameter)->load('resolutions');
        } else {
            $this->category = Category::where('slug', $parameter)->firstOrFail()->load('resolutions');
        }
    }

    public function render()
    {
        return view('livewire.category-page')->layout('layouts.app');
    }
}
