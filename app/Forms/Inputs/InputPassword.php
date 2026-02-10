<?php

namespace App\Forms\Inputs;

class InputPassword extends Input
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
        $data['type'] = 'password';

        return $data;
    }
}
