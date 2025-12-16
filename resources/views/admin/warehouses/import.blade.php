<x-admin-layout 
title="Importar Almacenes"
:breadcrumbs="[
    [
        'name' => 'Dashboard', 
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Almacenes', 
        'route' => route('admin.warehouses.index')
    ],
    [
        'name' => 'Importación de almacenes'
    ]
]">
    @livewire('admin.import-of-warehouses')
</x-admin-layout>