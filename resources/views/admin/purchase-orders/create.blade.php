<x-admin-layout 
title="Nueva orden de compra"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Ordenes de compra',
        'route' => route('admin.purchase-orders.index')
    ],
    [
        'name' => 'Nueva orden de compra'
    ]
]">
    @livewire('admin.purchase-orders-create')
</x-admin-layout>