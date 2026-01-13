<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SyncService
{
    protected array $handlers = [
        'user_relics' => \App\Services\SyncHandlers\GenericModelHandler::class,
        'user_relic_stats' => \App\Services\SyncHandlers\GenericModelHandler::class,
        'characters' => \App\Services\SyncHandlers\GenericModelHandler::class,
    ];

    protected array $models = [
        'user_relics' => \App\Models\UserRelic::class,
        'user_relic_stats' => \App\Models\UserRelicStat::class,
        'characters' => \App\Models\Character::class,
    ];

    public function applyChanges(array $changes): void
    {
        foreach ($changes as $index => $change) {
            if (empty($change['table']) || empty($change['type'])) {
                Log::warning('Skipping malformed change', compact('index', 'change'));
                continue;
            }

            $table = $change['table'];
            $handlerClass = $this->handlers[$table] ?? null;
            $modelClass = $this->models[$table] ?? null;

            if (!$handlerClass || !class_exists($handlerClass)) {
                Log::warning("Invalid handler mapping for table: {$table}", compact('change'));
                continue;
            }

            if (!$modelClass || !class_exists($modelClass)) {
                Log::warning("Invalid model mapping for table: {$table}", compact('change'));
                continue;
            }

            try {
                $handler = new $handlerClass([
                    'table' => $table,
                    'model' => $modelClass,
                ]);

                $handler->applyChange($change);

                Log::info('Change applied', compact('table', 'index'));
            } catch (\Throwable $e) {
                Log::error('Error applying change', [
                    'table' => $table,
                    'index' => $index,
                    'exception' => $e->getMessage(),
                ]);
            }
        }
    }
}
