<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MaterialGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve type 4 and 6 rarity 2 materials
        $baseMaterials = Material::where('rarity', 2)
                        ->whereIn('type_id', [4,6])
                        ->get();
        
        // Look up the next 2 ids of each material and fill their material_group with the rarity 2's name
        foreach ($baseMaterials as $material) {
            $groupSlug = Str::slug($material->name);

            $relatedMaterials = Material::whereIn('id', [
                $material->id,
                $material->id + 1,
                $material->id + 2
            ])->get();

            foreach ($relatedMaterials as $m) {
                $m->material_group = $groupSlug;
                $m->save();
            }
        }
    }
}
