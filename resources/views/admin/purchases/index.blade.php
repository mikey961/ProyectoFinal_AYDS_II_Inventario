<x-admin-layout 
title="Compras"
:breadcrumbs="[
    [
        'name' => 'Compras'
    ],
    [
        'name' => 'Listado de compras'
    ]

]">
    <x-slot name="action">
        <x-wire-button class="font-semibold" 
            href="{{ route('admin.purchases.create') }}"
            amber 
            rounded>
            Nueva compra
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.purchase-table')
</x-admin-layout>