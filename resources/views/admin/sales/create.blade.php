<x-admin-layout 
title="Nueva venta"
:breadcrumbs="[
    [
        'name' => 'Ventas'
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