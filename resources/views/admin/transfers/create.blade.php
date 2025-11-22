<x-admin-layout 
title="Nueva transferencia"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Transferencias',
        'route' => route('admin.transfers.index')
    ],
    [
        'name' => 'Nueva transferencia'
    ]
]">
    @livewire('admin.transfer-create')
</x-admin-layout>