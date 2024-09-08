<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Applicant extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        "name",
        "council_id",
    ];

    public function resolutions()
    {
        return $this->belongsToMany(Resolution::class, "applicant_resolution");
    }

    public function council()
    {
        return $this->belongsTo(Council::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "createdBy");
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'council_id' => $this->council_id,
        ];
    }
}
