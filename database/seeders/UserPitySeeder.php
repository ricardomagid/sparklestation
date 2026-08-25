<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserPitySeeder extends Seeder
{
    public function run(): void
    {
        User::each(function (User $user) {
            $pities = [
                ['type' => 'character', 'rarity' => 4],
                ['type' => 'character', 'rarity' => 5],
                ['type' => 'lightcone', 'rarity' => 4],
                ['type' => 'lightcone', 'rarity' => 5],
            ];

            foreach ($pities as $pity) {
                $user->pities()->firstOrCreate(
                    $pity,
                    [
                        'pity' => 0,
                        'guaranteed' => false,
                    ]
                );
            }
        });
    }
}