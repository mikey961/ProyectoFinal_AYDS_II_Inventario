<x-admin-layout 
title="Ventas"
:breadcrumbs="[
    [
        'name' => 'Ventas'
    ],
    [
        'name' => 'Listado de ventas'
    ]

]">
    <x-slot name="action">
        <x-wire-button class="font-semibold" 
            href="{{ route('admin.sales.create') }}"
            amber 
            rounded>
            Nueva venta
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.sale-table')
</x-admin-layout>