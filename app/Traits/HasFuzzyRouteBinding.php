<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exceptions\DisambiguationRequiredException;

trait HasFuzzyRouteBinding
{
    public function resolveRouteBinding($value, $field = null)
    {
        $query = method_exists($this, 'baseQuery') 
            ? $this->baseQuery() 
            : static::query();

        if (is_numeric($value)) {
            $model = $query->find($value);  
        } else {
            $model = $query->where('slug', $value)->first();
            
            if (!$model) {
                $matches = $this->findFuzzyMatches($value);
                if (count($matches) === 1) {
                    $freshQuery = method_exists($this, 'baseQuery') 
                        ? $this->baseQuery() 
                        : static::query();
                    $model = $freshQuery->where('slug', $matches[0])->first();
                } elseif (count($matches) > 1) {
                    throw new DisambiguationRequiredException(
                        static::class,
                        $matches,
                        $value,
                        'slug'
                    );
                }
            }
        }

        if (!$model) {
            $this->handleNotFound();
        }

        return $model;
    }

    protected function findFuzzyMatches(string $value, int $limit = 3): array
    {
        $allSlugs = static::pluck('slug')->toArray();

        return $this->findClosestNames($value, $allSlugs, $limit);
    }

    protected function handleNotFound()
    {
        $entityName = class_basename(static::class);
        
        throw new HttpException(
            404,
            "",
            null,
            [
                'Entity' => $entityName,
            ]
        );
    }

    abstract protected function findClosestNames(string $needle, array $haystack, int $limit): array;
}