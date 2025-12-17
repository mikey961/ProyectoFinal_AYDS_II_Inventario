<x-admin-layout
title="Reportes"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Clientes con más frecuencia'
    ]
]">
    @livewire('admin.datatables.top-customers-table')
</x-admin-layout>