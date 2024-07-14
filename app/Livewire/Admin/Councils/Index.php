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


    public function deleteCouncil($id)
    {
        Council::findOrFail($id)->delete();
        session()->flash('success', 'Council deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.councils.index', [
            'councils' => Council::paginate($this->perPage)
        ])->layout('layouts.admin');
    }
}
