<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        "name",
        "tag",
        "council_id",
        "image",
        "slug",
    ];

    protected $appends = [
        "tagged_name"
    ];

    public function resolutions()
    {
        return $this->hasMany(Resolution::class);
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

    public function getTaggedNameAttribute()
    {
        return $this->tag . " - " . $this->name;
    }

    // Mutator für slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($this->tagged_name);
        $this->save();
    }

    // Getter für slug
    public function getSlugAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['slug'] = Str::slug($this->tagged_name);
            $this->save();
        }

        return $this->attributes['slug'];
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tag' => $this->tag,
            'council_id' => $this->council_id,
        ];
    }
}
