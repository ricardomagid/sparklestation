<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DisambiguationController extends Controller
{
    public function show(Request $request)
    {
        $data = session('disambiguation');

        if (!$data) {
            abort(404, 'No disambiguation data found.');
        }   

        $modelClass = $data['model'];
        $query = $modelClass::whereIn($data['routeKey'], $data['matches'])
            ->select($this->getDisplayFields($modelClass));
        
        $relationships = $this->getRelationships($modelClass);
        if (!empty($relationships)) {
            $query->with($relationships);
        }
        
        $matches = $query->get();

        return view('disambiguation.show', [
            'items' => $matches,
            'original_search' => $data['search'],
            'entity_type' => class_basename($modelClass),
            'entity_route_prefix' => $this->getRoutePrefix($modelClass),
            'model_class' => $modelClass
        ]);
    }

    protected function getDisplayFields(string $modelClass): array
    {
        return match($modelClass) {
            \App\Models\Character::class => ['id', 'slug', 'name', 'element_id', 'path_id'],
            \App\Models\Lightcone::class => ['id', 'slug', 'name', 'path_id'],
            default => ['id', 'slug', 'name'],
        };
    }

    protected function getRelationships(string $modelClass): array
    {
        return match($modelClass) {
            \App\Models\Character::class => ['element', 'path'],
            \App\Models\Lightcone::class => ['path'],
            default => [],
        };
    }

    protected function getRoutePrefix(string $modelClass): string
    {
        return match($modelClass) {
            \App\Models\Character::class => 'characters',
            \App\Models\Lightcone::class => 'lightcones',
            \App\Models\Relic::class => 'relics',
            \App\Models\PlanarOrnament::class => 'relics',
            default => Str::plural(Str::snake(class_basename($modelClass))),
        };
    }
}