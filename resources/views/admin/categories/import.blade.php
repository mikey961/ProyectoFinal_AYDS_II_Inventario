<x-admin-layout 
title="Importar Categorías"
:breadcrumbs="[
    [
        'name' => 'Dashboard', 
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Categorías', 
        'route' => route('admin.categories.index')
    ],
    [
        'name' => 'Importación de categorías'
    ]
]">
    @livewire('admin.import-of-categories')
</x-admin-layout>