<?php

namespace App\Livewire\Admin;

use App\Models\Applicant;
use App\Models\Category;
use App\Models\Council;
use App\Models\Resolution;
use Livewire\Component;

class Dashboard extends Component
{


    public function render()
    {
        return view(
            'livewire.admin.dashboard',
            [
                'categories_count' => Category::count(),
                'resolutions_count' => Resolution::count(),
                'councils_count' => Council::count(),
                'applicants_count' => Applicant::count(),
                'latest_resolutions' => Resolution::latest()->limit(7)->get(),
                'latest_applicants' => Applicant::latest()
                    ->withCount('resolutions')
                    ->limit(7)
                    ->get(),
                'latest_categories' => Category::latest()
                    ->withCount('resolutions')
                    ->limit(7)
                    ->get(),
            ]
        )->layout('layouts.admin');
    }
}
