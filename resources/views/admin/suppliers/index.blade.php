<x-admin-layout 
title="Proveedores"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Proveedores'
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
        href="{{ route('admin.suppliers.create') }}"
        amber 
        rounded>
            Nuevo Proveedor
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.supplier-table')
    </div> 
</x-admin-layout>