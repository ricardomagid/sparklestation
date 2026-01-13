<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Patch;

class StoryArc extends Model
{
    use HasFactory;

    public function patches(): HasMany
    {
        return $this->hasMany(Patch::class);
    }

    public function getImgAttribute()
    {
        return asset("images/story_arcs/" . Str::slug($this->name) . ".png"); 
    }
}
