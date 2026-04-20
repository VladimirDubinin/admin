<?php

declare(strict_types=1);

namespace App\Shared\Application;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

abstract class ExcelService
{
    protected static string $fileName = 'export';

    protected Collection $items;
    protected Worksheet $worksheet;

    public function __construct(
        private readonly Spreadsheet $sheet,
    ) {
        $this->worksheet = $this->sheet->getActiveSheet();
    }

    public function setItems(Collection $users): static
    {
        $this->items = $users;
        return $this;
    }

    public function setTitle(string $title): static
    {
        $this->worksheet->setTitle($title);
        return $this;
    }

    /**
     * Метод должен возвращать массив с определением полей алиас => названиеСвойства
     *
     * @return array
     */
    abstract protected function getFieldsDefinition(): array;

    /**
     * Метод подготавливает данные для отображения на листе Excel
     *
     * @return void
     */
    public function export(): void
    {
        $data = $this->getFieldsDefinition();
        $this->worksheet->fromArray(array_values($data));

        $excelData = [];
        foreach ($this->items as $item) {
            $itemData = [];
            foreach ($data as $field => $alias) {
                $itemData[] = $item->$field ?? '';
            }
            $excelData[] = $itemData;
        }

        $this->worksheet->fromArray($excelData, null, 'A2');
        $this->write();
    }

    public function write(): void
    {
        $writer = new Xlsx($this->sheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . static::$fileName . '.xlsx"');
        $writer->save('php://output');
    }
}
