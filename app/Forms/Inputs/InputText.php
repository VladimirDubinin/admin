<?php

namespace App\Forms\Inputs;

class InputText extends Input
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
        $data['type'] = 'text';

        return $data;
    }
}
