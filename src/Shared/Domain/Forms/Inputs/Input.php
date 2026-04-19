<?php

declare(strict_types=1);

namespace App\Shared\Domain\Forms\Inputs;

/** Абстрактный класс с обобщенными для всех полей методами */
abstract class Input
{
    public string $name = '';
    public mixed $value = '';
    public string $label = '';
    public string $placeholder = '';
    public string $id = '';
    public bool $readOnly = false;

    public bool $disabled = false;
    public bool $accessDenied = false;
    public string | array $validationRule = '';
    public array $customFields = [];

    public function setNameAndId(string $value): static
    {
        $this->id = $value;
        $this->name = $value;
        return $this;
    }

    public function setName(string $value): static
    {
        $this->name = $value;
        return $this;
    }

    public function setId(string $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function setLabel(string $value): static
    {
        $this->label = $value;
        return $this;
    }

    public function setPlaceholder(string $value): static
    {
        $this->placeholder = $value;
        return $this;
    }

    public function setValue(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }

    public function setReadOnly(callable $value): static
    {
        $this->readOnly = $value();
        return $this;
    }

    public function setDisabled(callable $value): static
    {
        $this->disabled = $value();
        return $this;
    }

    public function setAccessDenied(callable $value): static
    {
        $this->accessDenied = $value();
        return $this;
    }

    public function setValidationRule(array | string $value): static
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
    public function setCustomFields(string $fieldName, mixed $value): static
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
                'disabled' => $this->disabled,
                'validation_rule' => $this->validationRule,
            ]
        );
    }
}
