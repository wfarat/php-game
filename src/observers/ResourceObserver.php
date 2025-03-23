<?php

namespace App\Observers;

class ResourceObserver
{
    private array $listeners = [];

    public function attach($listener): void
    {
        $this->listeners[] = $listener;
    }

    public function notify($userId): void
    {
        foreach ($this->listeners as $listener) {
            if (is_callable($listener)) {
                $listener($userId);
            }
        }
    }
}
