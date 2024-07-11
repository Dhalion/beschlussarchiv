<?php

namespace App\Livewire\Admin\Resolutions;

use App\Models\Resolution;
use Livewire\Component;

class Edit extends Component
{
    public $resolution;
    public $editorContent;

    public function mount($id)
    {
        $this->resolution = Resolution::findOrFail($id);
    }

    public function update()
    {
        $this->resolution->text = $this->editorContent;
        $this->resolution->save();
        $this->mount($this->resolution->id);
    }


    public function render()
    {
        return view('livewire.admin.resolutions.edit')
            ->layout('layouts.admin');
    }
}
