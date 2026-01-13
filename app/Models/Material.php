<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $appends = ['image_url'];

    /**
     * Get the image URL for the material
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('images/materials/' . $this->slug . '.webp');
    }
}
