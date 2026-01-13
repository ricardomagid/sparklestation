<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        // Populate the new material_group column of materials -- already populated
        // $this->call(MaterialGroupSeeder::class);

        // Replace the previous character_material_id with the respective material_group value of the material -- already updated
        //$this->call(UpdateCharacterMaterialGroupsSeeder::class);
    }
}
