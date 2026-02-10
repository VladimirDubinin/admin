<?php

namespace App\Forms\Inputs;

class InputSelect extends Input
{
    public array $items = [];

    /**
     * Метод для установки элементов селекта
     *
     * @param callable $itemsLoader
     * @return InputSelect
     */
    public function setItems(callable $itemsLoader): self
    {
        $this->items = $itemsLoader();
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

        return $data;
    }
}
