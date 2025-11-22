<x-admin-layout 
title="Transferencias"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Transferencias'
    ]

]">
    <x-slot name="action">
        <x-wire-button class="font-semibold" 
            href="{{ route('admin.transfers.create') }}"
            amber 
            rounded>
            Nueva Tranferencia
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.transfer-table')
</x-admin-layout>