<?php

namespace App\Livewire\Admin\Resolutions;

use App\Enums\ResolutionStatus;
use App\Models\Category;
use App\Models\Council;
use App\Models\Resolution;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{

    #[Validate('required|string')]
    public $title = '';

    #[Validate('required|string')]
    public $tag = '';

    #[Validate('required|numeric|digits:4')]
    public $year = '';

    #[Validate('required|string')]
    public $text = '';

    public $status = ResolutionStatus::Draft;

    #[Validate('required|exists:categories,id')]
    public $category_id = '';

    #[Validate('required|exists:councils,id')]
    public $council_id = '';



    public function store()
    {
        $this->validate();

        $createdResolution = Resolution::create($this->all());

        if (!$createdResolution) {
            session()->flash('error', 'Error creating resolution.');
            return;
        }
        session()->flash('success', 'Resolution created successfully.');
        return redirect()->route('admin.resolutions.index');
    }

    public function render()
    {
        return view('livewire.admin.resolutions.create', [
            "categories" => Category::all(),
            "councils" => Council::all(),

        ])->layout('layouts.admin');
    }
}
