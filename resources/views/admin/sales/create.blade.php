<x-admin-layout 
title="Nueva venta"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Listado de ventas',
        'route' => route('admin.sales.index')
    ],
    [
        'name' => 'Nueva venta'
    ]
]">
    @livewire('admin.sale-create')
</x-admin-layout>