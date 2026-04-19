<?php

declare(strict_types=1);

namespace App\Shared\Domain\Forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

abstract class AbstractForm
{
    /** Массив полей формы @var array */
    public array $form = [];

    /** Правила валидации @var array */
    public array $validationRules = [];

    /** Заполненные поля @var array */
    public array $completedFields = [];

    /** Идентификатор сущности, с которой ведётся работа @var int */
    public int $entityId = 0;

    /** Данные сущности @var Model */
    public Model $entityData;

    /** Метод должнен возвращать экземпляр формы @return self */
    abstract public function form(): self;

    /**
     * Метод должен возвращать массив с определением полей  ПолеВЗапросе => ПолеВБазеДанных
     *
     * @return array
     */
    abstract protected function getFieldsDefinition(): array;

    /**
     * Метод получает значения полей
     *
     * @param string $fieldName
     * @param mixed $defaultValue
     * @return mixed
     */
    protected function getFieldValue(string $fieldName, mixed $defaultValue = ''): mixed
    {
        if (empty($this->entityData)) {
            return $defaultValue;
        }

        $fields = $this->getFieldsDefinition();
        $key = array_search($fieldName, $fields, true);
        if (!empty($key)) {
            return $this->entityData->$key;
        }

        return $defaultValue;
    }

    /** Метод возвращает массив формы @return array */
    public function toArray(): array
    {
        return $this->form;
    }

    /**
     * Метод возвращает правила валидации для формы
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        $this->collectValidationRules($this->form);
        return $this->validationRules;
    }

    /**
     * Метод собирает правила валидации из формы
     *
     * @param array $form
     */
    public function collectValidationRules(array $form): void
    {
        foreach ($form as $item) {
            if (!is_array($item)) {
                continue;
            }

            if (Arr::has($item, ['validation_rule', 'name']) && !empty($item['validation_rule'])) {
                $this->validationRules[$item['name']] = $item['validation_rule'];
            }
        }
    }

    /**
     * Метод собирает имена полей, в которых хранятся значения в форме
     *
     * @param array $form
     */
    public function getFieldNames(array $form): void
    {
        foreach ($form as $item) {
            if (!is_array($item)) {
                continue;
            }

            if (Arr::has($item, ['value', 'name'])) {
                $this->completedFields[$item['name']] = $item['value'];
            }
        }
    }


    /**
     * Метод собирает значения полей из запроса
     *
     * @return array
     */
    public function getFieldsFromRequest(): array
    {
        $this->getFieldNames($this->form);

        $request = app(Request::class);

        $fieldsCompleted = [];

        $fields = $this->getFieldsDefinition();
        foreach ($fields as $field => $code) {
            if (array_key_exists($code, $this->completedFields)) {
                $fieldsCompleted[$field] = $request->input($code);
            }
        }

        if (!empty($this->entityData)) {
            $fieldsCompleted['id'] = $this->entityId;
        }

        return $fieldsCompleted;
    }

    /**
     * Сообщения об ошибках валидации
     */
    public function validationMessages(): array
    {
        return [];
    }

    /**
     * Метод выполняет валидацию формы
     */
    public function validate(): self
    {
        $request = app(Request::class);
        $validator = Validator::make(
            data: $request->all(),
            rules: $this->getValidationRules(),
            messages: $this->validationMessages()
        );
        $validator->validate();
        return $this;
    }
}
