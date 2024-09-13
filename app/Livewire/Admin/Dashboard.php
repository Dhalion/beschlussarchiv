<?php

namespace App\Livewire\Admin;

use App\Models\Applicant;
use App\Models\Category;
use App\Models\Council;
use App\Models\Resolution;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public ?Council $council = null;

    public function mount()
    {
        $user = Auth::getUser();
        $this->council = $user->admin ? Council::first() : $user->councils->first();
    }

    public function render()
    {
        return view(
            'livewire.admin.dashboard',
            [
                'categories_count' => Category::where('council_id', $this->council->id)
                    ->count(),
                'resolutions_count' => Resolution::where('council_id', $this->council->id)
                    ->count(),
                'councils_count' => Council::count(),
                'applicants_count' => Applicant::where('council_id', $this->council->id)->count(),
                'latest_resolutions' => Resolution::where("council_id", $this->council->id)
                    ->latest()->limit(7)->get(),
                'latest_applicants' => Applicant::where("council_id", $this->council->id)
                    ->latest()
                    ->withCount('resolutions')
                    ->limit(7)
                    ->get(),
                'latest_categories' => Category::where("council_id", $this->council->id)
                    ->latest()
                    ->withCount('resolutions')
                    ->limit(7)
                    ->get(),
            ]
        )->layout('layouts.admin');
    }
}
