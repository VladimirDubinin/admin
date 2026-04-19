<?php

namespace App\Shared\Domain\Forms\Inputs;

class Select extends Input
{
    public mixed $items = [];
    public bool $defaultNothing = false;
    public bool $multiple = false;

    /**
     * Метод для установки элементов селекта
     *
     * @param callable $itemsLoader
     * @return Select
     */
    public function setItems(callable $itemsLoader): self
    {
        $this->items = $itemsLoader();
        return $this;
    }

    public function multiple(): static
    {
        $this->multiple = true;
        return $this;
    }

    public function defaultNothing(): static
    {
        $this->defaultNothing = true;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        if ($this->accessDenied) {
            return [];
        }

        $data = parent::get();
        $data['type'] = 'select';
        $data['items'] = $this->items;
        $data['defaultNothing'] = $this->defaultNothing;
        $data['multiple'] = $this->multiple;

        return $data;
    }
}
