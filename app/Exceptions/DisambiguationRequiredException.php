<?php

namespace App\Exceptions;

use Exception;

class DisambiguationRequiredException extends Exception
{
    public string $modelClass;
    public array $matches;
    public string $search;
    public string $routeKey;

    public function __construct(string $modelClass, array $matches, string $search, string $routeKey)
    {
        $this->modelClass = $modelClass;
        $this->matches = $matches;
        $this->search = $search;
        $this->routeKey = $routeKey;
        
        parent::__construct('Multiple matches found');
    }

    public function render($request)
    {
        session([
            'disambiguation' => [
                'model' => $this->modelClass,
                'matches' => $this->matches,
                'search' => $this->search,
                'routeKey' => $this->routeKey
            ]
        ]);

        return redirect()->route('disambiguation.show');
    }
}