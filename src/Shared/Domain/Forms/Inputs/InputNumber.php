<?php

namespace App\Shared\Domain\Forms\Inputs;

class InputNumber extends Input
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
        $data['type'] = 'number';

        return $data;
    }
}
