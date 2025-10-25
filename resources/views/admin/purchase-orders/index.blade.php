<x-admin-layout 
title="Ordenes de compra"
:breadcrumbs="[
    [
        'name' => 'Compras'
    ],
    [
        'name' => 'Ordenes de compra'
    ]

]">
    <x-slot name="action">
        <x-wire-button class="font-semibold" 
            href="{{ route('admin.purchase-orders.create') }}"
            amber 
            rounded>
            Nueva orden de compra
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.purchase-orders-table')
</x-admin-layout>