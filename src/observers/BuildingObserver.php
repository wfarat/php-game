<?php

namespace App\observers;

class BuildingObserver
{
    private array $listeners = [];

    public function attach($listener): void
    {
        $this->listeners[] = $listener;
    }

    public function notify(): void
    {
        foreach ($this->listeners as $listener) {
            if (is_callable($listener)) {
                $listener();
            }
        }
    }
}
