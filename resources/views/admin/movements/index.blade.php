<x-admin-layout 
title="Entradas y Salidas"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Entradas y salidas'
    ]

]">
    <x-slot name="action">
        <x-wire-button class="font-semibold" 
            href="{{ route('admin.movements.create') }}"
            amber 
            rounded>
            Nuevo movimiento
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.movement-table')
</x-admin-layout>