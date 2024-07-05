<?php

namespace App\Models;

use App\Enums\ResolutionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Laravel\Scout\Searchable;

class Resolution extends Model
{
    use HasFactory, HasUuids, Searchable;


    protected $fillable = [
        "title",
        "tag",
        "year",
        "text",
        "status",
        "category_id",
        "council_id",
    ];

    protected $hidden = [
        "text"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applicants()
    {
        return $this->belongsToMany(Applicant::class);
    }

    public function council()
    {
        return $this->belongsTo(Council::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "createdBy");
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, "updatedBy");
    }


    public function getResolutionCode(): string
    {
        return "{$this->tag}-{$this->year}";
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'tag' => $this->tag,
            'year' => $this->year,
            'text' => $this->text,
        ];
    }
}
