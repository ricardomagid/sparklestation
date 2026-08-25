<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\Lightcone;

class StandardPoolSeeder extends Seeder
{
    public function run(): void
    {
        Character::whereIn('slug', [
            'himeko',
            'welt',
            'bronya',
            'gepard',
            'clara',
            'yanqing',
            'bailu',
            'trailblazer-1',
            'trailblazer-2',
            'trailblazer-51',
            'trailblazer-63'
        ])->update([
            'is_standard' => true,
        ]);

        Lightcone::whereIn('slug', [
            'night_on_the_milky_way',
            'something_irreplaceable',
            'but_the_battle_isnt_over',
            'in_the_name_of_the_world',
            'moment_of_victory',
            'sleep_like_the_dead',
            'time_waits_for_no_one'
        ])->update([
            'is_standard' => true,
        ]);
    }
}