<?php

namespace App\Shared\Domain\Forms\Inputs;

class InputRadio extends Input
{
    public array $items = [];

    /**
     * Метод для установки элементов селекта
     *
     * @param callable $itemsLoader
     * @return InputRadio
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
        $data['type'] = 'radio';
        $data['items'] = $this->items;

        return $data;
    }
}
