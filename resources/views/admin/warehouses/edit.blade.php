<x-admin-layout 
title="Editar alamacén"
:breadcrumbs="[
    [
        'name' => 'Inventario'
    ],
    [
        'name' => 'Almacenes',
        'route' => route('admin.warehouses.index')
    ],
    [
        'name' => 'Editar '.$warehouse->name
    ]
]">
    <x-wire-card>
        <form action="{{ route('admin.warehouses.update', $warehouse) }}" 
            method="POST" 
            class="space-y-4">
            @csrf
            @method('PUT')

            <x-wire-input 
                label="Nombre" 
                name="name" 
                placeholder="Nombre del alamacén"
                value="{{ old('name', $warehouse->name) }}"
            />
            <x-wire-input 
                label="Locación" 
                name="location" 
                placeholder="Locación del almacén"
                value="{{ old('address', $warehouse->location) }}"
            />
            <div class="flex justify-end">
                <x-button type="submit">
                    Actualizar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>