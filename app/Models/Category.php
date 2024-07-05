<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name",
        "tag",
        "council_id",
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

}
