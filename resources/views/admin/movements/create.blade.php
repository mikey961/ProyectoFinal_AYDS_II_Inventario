<x-admin-layout 
title="Nuevo movimiento"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Entradas y Salidas',
        'route' => route('admin.movements.index')
    ],
    [
        'name' => 'Nuevo movimiento'
    ]
]">
    @livewire('admin.movement-create')
</x-admin-layout>