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

    public $advancedSearch = false;


    public function render()
    {
        $searching = !($this->query == "");
        $searchStartTime = microtime(true);
        $resolutionsQuery = $this->query == "" ? Resolution::query() : Resolution::search($this->query);
        $searchTotalTime = microtime(true) - $searchStartTime;
        if (!empty($this->startYear)) {
            $searching = true;
            $this->advancedSearch = true;
            $resolutionsQuery->where("year", ">=", $this->startYear);
        }

        if (!empty($this->endYear)) {
            $searching = true;
            $this->advancedSearch = true;
            $resolutionsQuery->where("year", "<=", $this->endYear);
        }

        if (!empty($this->categoryId)) {
            $searching = true;
            $this->advancedSearch = true;
            $resolutionsQuery->where("category_id", $this->categoryId);
        }

        if (!empty($this->councilId)) {
            $searching = true;
            $this->advancedSearch = true;
            $resolutionsQuery->where("council_id", $this->councilId);
        }

        if ($searching) {
            $resolutions = $resolutionsQuery->paginate(10);
        } else {
            $resolutions = null;
        }

        return view("livewire.main-page", [
            "categories" => Category::withCount('resolutions')->get(),
            "resolutions" => $resolutions,
            "councils" => Council::get(),
            // searchTotal Time is in microseconds, we convert it to milliseconds and show 2 decimal places
            "searchTotalTime" => number_format($searchTotalTime * 1000, 2),
            "totalResults" => $resolutions ? $resolutions->total() : 0,
            "searching" => $searching,
            // if any of the filters are set, we are in advanced search mode true
            "advancedSearch" => $this->advancedSearch,

        ]);
    }
}
