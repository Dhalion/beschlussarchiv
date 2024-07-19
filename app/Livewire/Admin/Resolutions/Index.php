<?php

namespace App\Livewire\Admin\Resolutions;

use Livewire\Component;
use App\Models\Resolution;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $perPage = 10;

    #[Url(except: '')]
    public $search = '';

    public function deleteResolution($id)
    {
        Resolution::findOrFail($id)->delete();
        session()->flash('success', 'Resolution deleted successfully.');
    }

    public function createResolution()
    {
        return redirect()->route('admin.resolutions.create');
    }

    #[On('councilIdUpdated')]
    public function render()
    {
        $resolutions = $this->search == ''
            ? Resolution::where("council_id", session('councilId'))->paginate($this->perPage)
            : Resolution::search($this->search)->where("council_id", session('councilId'))->paginate($this->perPage);

        return view('livewire.admin.resolutions.index', [
            'resolutions' => $resolutions
        ])->layout('layouts.admin');
    }
}
