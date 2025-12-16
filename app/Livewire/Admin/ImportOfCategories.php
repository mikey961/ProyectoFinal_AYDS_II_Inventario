<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfCategories extends Component
{
    use WithFileUploads;

    public $file;
    public $errors = [];
    public $importedCount = 0;

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\CategoriesTemplateExport(), 'categories_template.xlsx');
    }

    public function importCategories()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        $categoryImport = new \App\Imports\CategoriesImport();
        Excel::import($categoryImport, $this->file);

        $this->errors = $categoryImport->getErrors();
        $this->importedCount = $categoryImport->getImportedCount();  

        if (count($this->errors) == 0) {
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Importación exitosa',
                'text' => "Se han importado {$this->importedCount} categorías correctamente."
            ]);

            return redirect()->route('admin.categories.index');
        } 
    }
    
    public function render()
    {
        return view('livewire.admin.import-of-categories');
    }
}