<x-admin-layout
title="Productos"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Productos'
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

            .image-product {
                width: 5rem;
                height: 3.5rem;
                object-fit: cover;
                object-position: center;
            }
        </style>
    @endpush

    <x-slot name="action">
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.products.import') }}"
            sky
            rounded>
            <i class="fas fa-file-import"></i>
            Importar Productos
        </x-wire-button>
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.products.create') }}"
            amber 
            rounded>
            <i class="fas fa-plus"></i>
            Nuevo Producto
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.product-table')
    </div>
</x-admin-layout>