<?php

namespace App\Services\SyncHandlers;

use Illuminate\Support\Facades\Log;

class GenericModelHandler implements SyncHandlerInterface
{
    protected ?string $modelClass;
    protected string $table;


    public function __construct(array $config = [])
    {
        $this->table = $config['table'] ?? '';
        $this->modelClass = $config['model'] ?? null;
    }


    public function applyChange(array $change): void
    {
        $type = strtoupper($change['type'] ?? '');
        $columns = $change['columns'] ?? [];

        if (!$this->modelClass) {
            Log::warning('GenericModelHandler has no model for table', ['table' => $this->table]);
            return;
        }

        switch ($type) {
            case 'INSERT':
                $this->modelClass::create($columns);
            break;

            case 'MODIFY':
            case 'UPDATE':
                if (!isset($change['id'])) {
                    Log::warning('MODIFY without id skipped', ['change' => $change]);
                    return;
                }

                $this->modelClass::query()
                ->where('id', $change['id'])
                ->update($columns);
                break;

            case 'DELETE':
                if (!isset($change['id'])) {
                    Log::warning('DELETE without id skipped', ['change' => $change]);
                    return;
                }

                $this->modelClass::destroy($change['id']);
                break;

            default:
                Log::warning('Unknown change type', ['type' => $type, 'change' => $change]);
                break;
        }
    }
}