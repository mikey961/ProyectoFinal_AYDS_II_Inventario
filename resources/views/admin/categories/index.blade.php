<x-admin-layout 
title="Categorías"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Categorías'
    ]
]">
    <x-slot name="action">
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.categories.import') }}"
            sky
            rounded>
            <i class="fas fa-file-import"></i>
            Importar Categorías
        </x-wire-button>
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.categories.create') }}"
            amber 
            rounded>
            <i class="fas fa-plus"></i>
            Nueva Categoría
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.category-table')
    </div> 
</x-admin-layout>