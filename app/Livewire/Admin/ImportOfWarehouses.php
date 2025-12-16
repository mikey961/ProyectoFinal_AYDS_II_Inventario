<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfWarehouses extends Component
{
    use WithFileUploads;

    public $file;
    public $errors = [];
    public $importedCount = 0;

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\WarehousesTemplateExport(), 'warehouses_template.xlsx');
    }

    public function importCategories()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        $warehouseImport = new \App\Imports\WarehousesImport();
        Excel::import($warehouseImport, $this->file);

        $this->errors = $warehouseImport->getErrors();
        $this->importedCount = $warehouseImport->getImportedCount();  

        if (count($this->errors) == 0) {
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Importación exitosa',
                'text' => "Se han importado {$this->importedCount} almacenes correctamente."
            ]);

            return redirect()->route('admin.warehouses.index');
        } 
    }
    
    public function render()
    {
        return view('livewire.admin.import-of-warehouses');
    }
}