<?php

namespace App\Services\SyncHandlers;

interface SyncHandlerInterface
{
    public function applyChange(array $change): void;
}