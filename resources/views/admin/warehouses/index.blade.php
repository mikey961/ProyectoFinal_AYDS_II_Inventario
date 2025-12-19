<x-admin-layout 
title="Almacenes"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Almacenes'
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
            href="{{ route('admin.warehouses.import') }}"
            sky
            rounded>
            <i class="fas fa-file-import"></i>
            Importar Almacenes
        </x-wire-button>
        <x-wire-button
        class="font-semibold" 
        href="{{ route('admin.warehouses.create') }}"
        amber 
        rounded>
        <i class="fas fa-plus"></i>
            Nuevo Almacen
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.warehouse-table')
    </div> 
</x-admin-layout>