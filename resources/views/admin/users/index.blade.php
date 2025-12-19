<x-admin-layout 
title="Usuarios"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Usuarios'
    ]

]">
    <x-slot name="action">
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.users.create') }}"
            amber 
            rounded>
            <i class="fas fa-plus"></i>
            Nueva Usuario
        </x-wire-button>
    </x-slot>

    <div class="mt-4">
        @livewire('admin.datatables.user-table')
    </div>
</x-admin-layout>