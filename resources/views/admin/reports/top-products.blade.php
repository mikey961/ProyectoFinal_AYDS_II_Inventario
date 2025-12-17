<x-admin-layout
title="Reportes"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Productos más vendidos'
    ]
]">
    @livewire('admin.datatables.top-products-table')
</x-admin-layout>