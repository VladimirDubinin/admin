<?php

declare(strict_types=1);

namespace App\Forms\Inputs;

/** Абстрактный класс с обобщенными для всех полей методами */
abstract class Input
{
    public string $name = '';
    public string $value = '';
    public string $label = '';
    public string $id = '';
    public bool $readOnly = false;
    public bool $accessDenied = false;
    public string $validationRule = '';
    public array $customFields = [];

    public function setNameAndId(string $value): self
    {
        $this->id = $value;
        $this->name = $value;
        return $this;
    }

    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function setId(string $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function setLabel(string $value): self
    {
        $this->label = $value;
        return $this;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function setReadOnly(callable $value): self
    {
        $this->readOnly = $value();
        return $this;
    }

    public function setAccessDenied(callable $value): self
    {
        $this->accessDenied = $value();
        return $this;
    }

    public function setValidationRule(string $value): self
    {
        $this->validationRule = $value;
        return $this;
    }

    /**
     * Метод устанавливает значение кастомного поля.
     * Именя кастомных полей не заменяют собой имена основных, а при совпадении будут использоваться основные поля
     *
     * @param string $fieldName
     * @param mixed $value
     * @return $this
     */
    public function setCustomFields(string $fieldName, mixed $value): self
    {
        $this->customFields[$fieldName] = $value;
        return $this;
    }

    /**
     * Метод должен реализовать сбор всех данных и подготовить поле для выдачи
     *
     * @return array
     */
    public function get(): array
    {
        return array_merge(
            $this->customFields,
            [
                'id' => $this->id,
                'name' => $this->name,
                'value' => $this->value,
                'label' => $this->label,
                'read_only' => $this->readOnly,
                'access_denied' => $this->accessDenied,
                'validation_rule' => $this->validationRule,
            ]
        );
    }
}
