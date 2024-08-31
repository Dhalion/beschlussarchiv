<?php

namespace App\Livewire\Admin\Resolutions;

use App\Enums\ResolutionStatus;
use App\Models\Category;
use App\Models\Resolution;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{

    use Toast;

    public $resolution;
    public $title;
    public $tag;
    public $year;
    public $status;
    public $category_id;
    public $council_id;
    public $applicants = [];

    public $editorContent;

    public $categories = [];

    public function mount($resolutionId)
    {
        $this->resolution = Resolution::findOrFail($resolutionId);

        $this->validateCouncilAccess();

        $this->title = $this->resolution->title;
        $this->tag = $this->resolution->tag;
        $this->year = $this->resolution->year;
        $this->status = $this->resolution->status;
        $this->category_id = $this->resolution->category_id;
        $this->council_id = $this->resolution->council_id;
        $this->applicants = $this->resolution->applicants->pluck('id')->toArray();
        $this->editorContent = $this->resolution->text;

        $this->categories = Category::where("council_id", $this->resolution->council_id)
            ->orderBy('name')
            ->get();
    }

    public function update()
    {
        $this->resolution->text = $this->editorContent;
        $this->resolution->title = $this->title;
        $this->resolution->tag = $this->tag;
        $this->resolution->year = $this->year;
        $this->resolution->status = $this->status;
        $this->resolution->category_id = $this->category_id;
        $this->resolution->applicants()->sync($this->applicants);
        $this->resolution->updated_by = auth()->id();
        $this->resolution->updated_at = now();

        $this->resolution->save();
        $this->toast('success', 'Beschluss aktualisiert', 'Der Beschluss wurde erfolgreich aktualisiert.');
        // reload the page
        return redirect()->route('admin.resolutions.edit', $this->resolution->id);
    }


    #[On('councilIdUpdated')]
    public function validateCouncilAccess()
    {
        $resolutionBelongsToSelectedCouncil = session('councilId') == $this->resolution->council_id;
        if (!$resolutionBelongsToSelectedCouncil) {
            redirect()->route('admin.resolutions.index');
        }
    }


    public function render()
    {
        return view('livewire.admin.resolutions.edit', [
            "resolutionStates" => ResolutionStatus::cases(),
        ])
            ->layout('layouts.admin');
    }
}
