<x-admin-layout
title="Kardex de productos"
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
        'name' => 'Kardex de ' . $product->name
    ]
]">
    @livewire('admin.kardex', ['product' => $product])
</x-admin-layout>