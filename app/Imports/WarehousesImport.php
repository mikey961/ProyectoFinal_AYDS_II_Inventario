<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WarehousesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    private array $errors = [];
    private int $importedCount = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $data = $row->toArray();
            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'location' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row' => $index + 1,
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }
            Warehouse::create($data);
            $this->importedCount++;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }
}
