<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Resolution;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Resolutions extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $perPage = 10;

    #[Url(except: '')]
    public $search = '';

    public function render()
    {
        $resolutions = $this->search == ''
            ? Resolution::paginate($this->perPage)
            : Resolution::search($this->search)->paginate($this->perPage);


        return view('livewire.admin.resolutions', [
            'resolutions' => $resolutions
        ])->layout('layouts.admin');
    }
}
