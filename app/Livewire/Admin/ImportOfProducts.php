<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfProducts extends Component
{
    use WithFileUploads;

    public $file;
    public $errors = [];
    public $importedCount = 0;

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\ProductsTemplateExport(), 'products_template.xlsx');
    }

    public function importProducts()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        $productImport = new \App\Imports\ProductsImport();
        Excel::import($productImport, $this->file);

        $this->errors = $productImport->getErrors();
        $this->importedCount = $productImport->getImportedCount();  

        if (count($this->errors) == 0) {
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Importación exitosa',
                'text' => "Se han importado {$this->importedCount} productos correctamente."
            ]);

            return redirect()->route('admin.products.index');
        } 
    }

    public function render()
    {
        return view('livewire.admin.import-of-products');
    }
}
