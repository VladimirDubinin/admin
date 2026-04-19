<?php

namespace App\Shared\Domain\Forms\Inputs;

class InputFile extends Input
{
    public string $accept = '';
    public bool $multiple = false;

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        if ($this->accessDenied) {
            return [];
        }

        $data = parent::get();
        $data['type'] = 'file';

        return $data;
    }

    /**
     * Ограничение расширений файлов
     *
     * @param string $value
     * @return self
     */
    public function setAcceptExtensions(string $value): self
    {
        $this->accept = $value;
        return $this;
    }

    public function multiple(): static
    {
        $this->multiple = true;
        return $this;
    }
}
