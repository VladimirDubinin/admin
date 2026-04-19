<?php

namespace App\Shared\Domain\Forms\Inputs;

class InputTextarea extends Input
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
        $data['type'] = 'textarea';

        return $data;
    }
}
