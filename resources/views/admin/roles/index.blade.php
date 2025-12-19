<x-admin-layout
title="Roles"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Listado de roles'
    ]
]">
    <x-slot name="action">
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.roles.create') }}"
            amber 
            rounded>
            <i class="fas fa-plus"></i>
            Nuevo Rol
        </x-wire-button>
    </x-slot>
    <div class="mt-4">
        @livewire('admin.datatables.role-table')
    </div>
</x-admin-layout>