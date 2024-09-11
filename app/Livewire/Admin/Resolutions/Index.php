<?php

namespace App\Livewire\Admin\Resolutions;

use Livewire\Component;
use App\Models\Resolution;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
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
        ['key' => 'title', 'label' => 'Titel'],
        ['key' => 'created_at', 'label' => 'Erstellt am'],
        ['key' => 'applicants', 'label' => 'Antragsteller*innen'],
        ['key' => 'actions', 'label' => 'Aktionen'],
    ];

    public $sortBy = ['column' => 'tag', 'direction' => 'asc'];

    public bool $showDeleteModal = false;
    public $resolutionBeingDeleted = null;

    public function confirmResolutionDeletion($id)
    {
        $this->resolutionBeingDeleted = Resolution::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteResolution()
    {
        $this->resolutionBeingDeleted->delete();
        $this->showDeleteModal = false;
        $this->toast("success", "Beschluss gelöscht.");
    }

    public function createResolution()
    {
        return redirect()->route('admin.resolutions.create');
    }

    function getColorFromTag($tag)
    {
        $firstLetter = strtoupper(substr($tag, 0, 1));
        $hash = md5($firstLetter);
        $color = '#' . substr($hash, 0, 6);
        return $color;
    }


    #[On('councilIdUpdated')]
    public function render()
    {
        $resolutions = $this->search == ''
            ? Resolution::where("council_id", session('councilId'))->orderBy(...array_values($this->sortBy))->paginate($this->perPage)
            : Resolution::search($this->search)->where("council_id", session('councilId'))->orderBy(...array_values($this->sortBy))->paginate($this->perPage);

        return view('livewire.admin.resolutions.index', [
            'resolutions' => $resolutions
        ])->layout('layouts.admin');
    }
}
