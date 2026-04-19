<?php

namespace App\Users\Application\Services;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserExcelService
{
    private Collection $users;
    private Worksheet $worksheet;

    public function __construct(
        private readonly Spreadsheet $sheet,
    ) {
        $this->worksheet = $this->sheet->getActiveSheet();
        $this->worksheet->setTitle('Список пользователей');
        $headerData = ["Имя", "Email", "Роль", "Дата регистрации"];
        $this->worksheet->fromArray($headerData);
    }

    public function setItems(Collection $users): self
    {
        $this->users = $users;
        return $this;
    }
    public function export(): void
    {
        $excelData = [];
        foreach ($this->users as $user) {
            $excelData[] = [
                $user->name,
                $user->email,
                $user->roles,
                $user->created_at,
            ];
        }
        $this->worksheet->fromArray($excelData, null, 'A2');

        $writer = new Xlsx($this->sheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="uses.xlsx"');
        $writer->save('php://output');
    }
}
