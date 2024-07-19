<?php

namespace App\Livewire\Admin;

use App\Models\Council;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AsideMenu extends Component
{

    public $councilId = "null";


    public function mount()
    {
        $this->councilId = session('councilId') ?? $this->getUsersDefaultCouncil();
    }

    public function updateCouncilId()
    {
        session(['councilId' => $this->councilId]);
    }

    private function getUsersDefaultCouncil()
    {
        $user = Auth::getUser();
        $defaultCouncil = $user->admin ? Council::first() : $user->councils->first();
        $this->councilId = $defaultCouncil->id;
        $this->updateCouncilId();
        return $defaultCouncil->id;
    }

    public function render()
    {
        $user = Auth::getUser();
        $councils = $user->admin ? Council::all() : $user->councils;

        if (!$this->councilId || $this->councilId == "null") {
            $this->councilId = $this->getUsersDefaultCouncil();
        }

        return view('livewire.admin.aside-menu', [
            'councils' => $councils ?? []
        ]);
    }
}
