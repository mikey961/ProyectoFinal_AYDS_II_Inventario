<x-admin-layout 
title="Nuevo alamcén"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Almacenes',
        'route' => route('admin.warehouses.index')
    ],
    [
        'name' => 'Nuevo almacén'
    ]
]">
    <x-wire-card>
        <form action="{{ route('admin.warehouses.store') }}" 
            method="POST" 
            class="space-y-4">
            @csrf

            <x-wire-input 
                label="Nombre" 
                name="name" 
                placeholder="Nombre del almacén"
                value="{{ old('name') }}"
            />
            <x-wire-input 
                label="Locación" 
                name="location" 
                placeholder="Locación del almacén"
                value="{{ old('location') }}"
            />
            <div class="flex justify-end">
                <x-button type="submit">
                    Guardar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>