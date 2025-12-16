<x-admin-layout 
title="Importar Productos"
:breadcrumbs="[
    [
        'name' => 'Dashboard', 
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Productos', 
        'route' => route('admin.products.index')
    ],
    [
        'name' => 'Importación de productos'
    ]
]">
    @livewire('admin.import-of-products')
</x-admin-layout>