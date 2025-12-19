<x-admin-layout 
title="Clientes"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Clientes'
    ]

]">
    @push('css')
        <style>
            table td {
                white-space: normal !important;
                word-wrap: break-word;
                overflow-wrap: break-word;
                max-width: 400px;
            }

            table th {
                white-space: nowrap;
            }

            table {
                table-layout: auto;
            }
        </style>
    @endpush

    <x-slot name="action">
        <x-wire-button
        class="font-semibold" 
        href="{{ route('admin.customers.create') }}"
        amber 
        rounded>
            Nuevo Cliente
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.customer-table')
    </div> 
</x-admin-layout>