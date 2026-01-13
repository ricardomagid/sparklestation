<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $appends = ['img'];

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'verification_code', 
        'password',
        'profile_pic',
        'items_per_page',
        'columns_to_show'
    ];

    /**
     * The attributes that should be hidden for serialization
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The default attributes for the user model
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'items_per_page' => 20,
        'columns_to_show' => '["rarity", "element", "path", "faction"]',
        'profile_pic' => 'default.webp'
    ];
    
    /**
     * Get the attributes that should be cast
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'columns_to_show' => 'array',
        ];
    }

    public function relics(): HasMany
    {
        return $this->hasMany(UserRelic::class, 'user_id');
    }

    public function getImgAttribute() 
    {
        $basePath = "images/users/";
        $filename = $this->profile_pic ?? 'default.webp';

        return asset($basePath . $filename);
    }
}
