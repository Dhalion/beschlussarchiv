<?php

namespace App\Livewire\Admin\Councils;

use App\Models\Council;
use Livewire\Component;

class Create extends Component
{

    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function createCouncil()
    {
        $this->validate();

        $council = new Council();
        $council->name = $this->name;
        $council->save();

        session()->flash('success', 'Council created successfully.');

        return redirect()->route('admin.councils.index');
    }

    public function render()
    {
        return view('livewire.admin.councils.create')->layout('layouts.admin');
    }
}
