<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name"
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
}
