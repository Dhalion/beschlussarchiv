<?php

namespace App\Http\Controllers;

use App\Models\Resolution;
use Illuminate\Http\Request;

class ResolutionFrontendController extends Controller
{
    /*
        Resolve the resolution based on the parameter and the optional councilId
        The parameter can be either the ID, the year-tag, or the tag-year
        If the councilId is provided, the resolution will be resolved within the council

        @param string $parameter The parameter (YearTag, TagYear or Id) to resolve the resolution
        @param ?int $councilId The council ID to resolve the resolution within

        @return \Illuminate\View\View The view of the resolution
    */
    public function resolveResolution($parameter, $councilId = null)
    {
        //* Try to match the Tag format first
        // Test for the format YEAR-TAG
        if (preg_match('/^\d{4}-[A-Za-z]{0,4}\d{0,4}$/', $parameter)) {
            [$year, $tag] = explode('-', $parameter);
            return $this->showResolutionByYearTag($year, $tag, $councilId);
        }
        // Test for the format TAG-YEAR
        else if (preg_match('/^[A-Za-z]{0,4}\d{0,4}-\d{4}$/', $parameter)) {
            [$tag, $year] = explode('-', $parameter);
            return $this->showResolutionByYearTag($year, $tag, $councilId);
        }
        //* Else try to match the ID format
        return $this->showResolutionById($parameter);
    }

    /*
        Resolve the resolution based on the parameter and the councilId
        The resolution will be resolved within the council
        This function calls the resolveResolution function

        @param ?int $councilId The council ID to resolve the resolution within
        @param string $parameter The parameter (YearTag, TagYear or Id) to resolve the resolution

        @return \Illuminate\View\View The view of the resolution
    */
    public function resolveResolutionWithCouncil($councilId, $parameter)
    {
        $stop = 0;
        return $this->resolveResolution($parameter, $councilId);
    }


    public function showResolutionById($id)
    {
        return view('page.resolution', [
            'resolution' => Resolution::findOrFail($id)
        ]);
    }

    public function showResolutionByYearTag($year, $tag, $councilId = null)
    {
        // $tag is of format 2023-A12
        // explode it to get the year and the slug
        $resolutionQuery = Resolution::query();
        $resolutionQuery->where('tag', $tag)
            ->where('year', $year);
        if ($councilId) {
            $resolutionQuery->where('council_id', $councilId);
        }

        return view('page.resolution', [
            'resolution' => $resolutionQuery->firstOrFail()
        ]);
    }
}
