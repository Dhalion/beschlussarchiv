<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Resolution;
use Livewire\Attributes\Url;
use Livewire\Component;

class MainPage extends Component
{

    #[Url]
    public ?string $search = '';

    public function render()
    {
        return view('livewire.main-page', [
            'categories' => Category::get(),
            "resolutions" => Resolution::search($this->search)->get()
        ]);
    }
}
