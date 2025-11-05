<x-admin-layout 
title="Nueva compra"
:breadcrumbs="[
    [
        'name' => 'Compras'
    ],
    [
        'name' => 'Listado de compras',
        'route' => route('admin.purchases.index')
    ],
    [
        'name' => 'Nueva compra'
    ]
]">
    @livewire('admin.purchase-create')
</x-admin-layout>