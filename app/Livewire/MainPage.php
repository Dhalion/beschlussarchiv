<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Council;
use App\Models\Resolution;
use Livewire\Attributes\Url;


class MainPage extends Component
{

    #[Url(except: '')]
    public ?string $query = "";
    #[Url(except: '')]
    public ?string $startYear = "";
    #[Url(except: '')]
    public ?string $endYear = "";
    #[Url(except: '')]
    public ?string $categoryId = "";
    #[Url(except: '')]
    public ?string $councilId = "";


    public function render()
    {
        $searching = !($this->query == "");
        $resolutionsQuery = Resolution::query();
        if (!empty($this->startYear)) {
            $searching = true;
            $resolutionsQuery->where("year", ">=", $this->startYear);
        }

        if (!empty($this->endYear)) {
            $searching = true;
            $resolutionsQuery->where("year", "<=", $this->endYear);
        }

        $searching = true;
        if (!empty($this->categoryId)) {
            $searching = true;
            $resolutionsQuery->where("category_id", $this->categoryId);
        }

        if (!empty($this->councilId)) {
            $searching = true;
            $resolutionsQuery->where("council_id", $this->councilId);
        }

        if ($searching) {
            $resolutions = Resolution::search($this->query)->get();
        } else {
            $resolutions = null;
        }

        return view("livewire.main-page", [
            "categories" => Category::get(),
            "resolutions" => $resolutions,
            "councils" => Council::get(),
            // if any of the filters are set, we are in advanced search mode true
            "advancedSearch" => !empty($this->query) || !empty($this->startYear) || !empty($this->endYear) || !empty($this->categoryId) || !empty($this->councilId)
        ]);
    }
}
