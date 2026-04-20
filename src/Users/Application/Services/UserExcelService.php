<?php

declare(strict_types=1);

namespace App\Users\Application\Services;

use App\Shared\Application\ExcelService;

class UserExcelService extends ExcelService
{
    protected function getFieldsDefinition(): array
    {
        return [
            "name" => "Имя",
            "email" => "Email",
            "roles" => "Роль",
            "created_at" => "Дата регистрации",
        ];
    }
}
