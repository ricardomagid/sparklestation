<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $appends = ['img'];

    protected static function booted(): void
    {
        static::created(function (User $user) {
            $user->pities()->createMany([
                [
                    'type' => 'character',
                    'rarity' => '4',
                    'pity' => 0,
                    'guaranteed' => false,
                ],
                [
                    'type' => 'character',
                    'rarity' => '5',
                    'pity' => 0,
                    'guaranteed' => false,
                ],
                [
                    'type' => 'lightcone',
                    'rarity' => '4',
                    'pity' => 0,
                    'guaranteed' => false,
                ],
                [
                    'type' => 'lightcone',
                    'rarity' => '5',
                    'pity' => 0,
                    'guaranteed' => false,
                ],
            ]);
        });
    }

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
        'columns_to_show',
        'featured_character_id',
        'featured_lightcone_id',
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

    public function characters(): HasMany
    {
        return $this->hasMany(UserCharacter::class);
    }

    public function lightcones(): HasMany
    {
        return $this->hasMany(UserLightcone::class);
    }

    public function pulls(): HasMany
    {
        return $this->hasMany(UserPull::class);
    }

    public function pities(): HasMany
    {
        return $this->hasMany(UserPity::class);
    }

    public function featuredCharacter(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'featured_character_id');
    }

    public function featuredLightcone(): BelongsTo
    {
        return $this->belongsTo(Lightcone::class, 'featured_lightcone_id');
    }

    public function getImgAttribute()
    {
        $basePath = "images/users/";
        $filename = $this->profile_pic ?? 'default.webp';

        return asset($basePath . $filename);
    }
}
