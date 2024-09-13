<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Council extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name",
        "slug",
        "shortName",
    ];

    public function resolutions()
    {
        return $this->hasMany(Resolution::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getSlugAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['slug'] = Str::slug($this->name);
        }

        return $this->attributes['slug'];
    }
}
