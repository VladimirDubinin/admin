<?php

namespace App\Shared\Domain\Forms\Inputs;

class InputCheckbox extends Input
{
    /**
     * @inheritDoc
     */
    public function get(): array
    {
        if ($this->accessDenied) {
            return [];
        }

        $data = parent::get();
        $data['type'] = 'checkbox';

        return $data;
    }
}
