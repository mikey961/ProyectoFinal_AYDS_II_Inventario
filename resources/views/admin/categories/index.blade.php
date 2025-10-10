<x-admin-layout 
title="Categorías"
:breadcrumbs="[
    [
        'name' => 'Categorías'
    ]
]">
    <x-slot name="action">
        <x-wire-button amber rounded href="{{ route('admin.categories.create') }}" class="font-semibold">
            Nuevo Categoría
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.category-table')
    </div>  
</x-admin-layout>