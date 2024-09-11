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
    public $categoryId;
    public $councilId;
    public $applicants = [];

    public $editorContent;

    public $categories = [];

    public function mount(?string $resolutionId = null, $createNew = false)
    {
        if (!$resolutionId && $createNew) {
            // Erstellen Sie eine neue Instanz des Modells, ohne es zu speichern
            $this->resolution = new Resolution(
                [
                    'council_id' => session('councilId'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]
            );
            $this->title = '';
            $this->tag = '';
            $this->year = now()->year;
            $this->status = ResolutionStatus::Draft; // Beispiel für einen Standardstatus
            $this->categoryId = null;
            $this->councilId = session('councilId');
            $this->applicants = [];
            $this->editorContent = '';
        } else {
            $this->resolution = Resolution::findOrFail($resolutionId);

            $this->title = $this->resolution->title;
            $this->tag = $this->resolution->tag;
            $this->year = $this->resolution->year;
            $this->status = $this->resolution->status;
            $this->categoryId = $this->resolution->category_id;
            $this->councilId = $this->resolution->council_id;
            $this->applicants = $this->resolution->applicants->pluck('id')->toArray();
            $this->editorContent = $this->resolution->text;
        }

        $this->categories = Category::where("council_id", $this->resolution->council_id)
            ->get()
            ->sortBy('tagged_name');
    }

    public function update()
    {
        // Validate the data
        $this->validate([
            'title' => 'required|string',
            'tag' => 'required|string',
            'year' => 'required|integer',
            'status' => 'required',
            'categoryId' => 'required|exists:categories,id',
            'councilId' => 'required|exists:councils,id',
            'applicants' => 'required|array',
            'editorContent' => 'required|string',
        ]);

        $this->resolution->text = $this->editorContent;
        $this->resolution->title = $this->title;
        $this->resolution->tag = $this->tag;
        $this->resolution->year = $this->year;
        $this->resolution->status = $this->status;
        $this->resolution->category_id = $this->categoryId;
        $this->resolution->council_id = $this->councilId;
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
            $this->toast(
                "warning",
                "Zugriff verweigert",
                "Sie haben keinen Zugriff auf dieses Gremium."
            );
            redirect()->route('admin.resolutions.index');
        }
    }


    public function render()
    {
        return view('livewire.admin.resolutions.edit', [
            "resolutionStates" => ResolutionStatus::cases(),
        ])->layout('layouts.admin');
    }
}
