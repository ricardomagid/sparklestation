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
        // Get all characters
        $characters = DB::table('characters')->get();

        foreach ($characters as $character) {
            // Get the material group slug for character material
            $materialGroupSlug = DB::table('materials')
                ->where('id', $character->enemy_material_group)
                ->value('material_group');

            // Update the character material group
            DB::table('characters')
                ->where('id', $character->id)
                ->update(['enemy_material_group' => $materialGroupSlug]);
        }
    }
}

