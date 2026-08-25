<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateCharacterMaterialGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $characters = DB::table('characters')->get();

        foreach ($characters as $character) {
            if (!is_numeric($character->enemy_material_group)) {
                continue;
            }

            $materialGroupSlug = DB::table('materials')
                ->where('id', $character->enemy_material_group)
                ->value('material_group');

            DB::table('characters')
                ->where('id', $character->id)
                ->update([
                    'enemy_material_group' => $materialGroupSlug
                ]);
        }
    }
}

