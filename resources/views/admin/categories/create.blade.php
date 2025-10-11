<x-admin-layout 
title="Nueva categoría"
:breadcrumbs="[
    [
        'name' => 'Inventario'
    ],
    [
        'name' => 'Categorías',
        'route' => route('admin.categories.index')
    ],
    [
        'name' => 'Nueva categoría'
    ]
]">
    <x-wire-card>
        <form action="{{ route('admin.categories.store') }}" 
            method="POST" 
            class="space-y-4">
            @csrf

            <x-wire-input 
                label="Nombre" 
                name="name" 
                placeholder="Nombre de la categoría"
                value="{{ old('name') }}"
            />
            <x-wire-textarea 
                label="Descripción" 
                name="description" 
                placeholder="Ingrese una descripción a la categoría">
                {{ old('description') }}
            </x-wire-textarea>
            <div class="flex justify-end">
                <x-button type="submit">
                    Guardar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>