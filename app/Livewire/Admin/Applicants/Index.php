<?php

namespace App\Livewire\Admin\Applicants;

use App\Models\Applicant;
use Livewire\Attributes\On;
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

    public function deleteApplicant($id)
    {
        Applicant::findOrFail($id)->delete();
        session()->flash('success', 'Applicant deleted successfully.');
    }

    #[On('councilIdUpdated')]
    public function render()
    {
        $applicants = $this->search == ''
            ? Applicant::where("council_id", session('councilId'))->paginate($this->perPage)
            : Applicant::search($this->search)->where("council_id", session('councilId'))->paginate($this->perPage);
        return view('livewire.admin.applicants.index', [
            'applicants' => $applicants
        ])->layout('layouts.admin');
    }
}
