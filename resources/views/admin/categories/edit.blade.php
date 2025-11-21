<x-admin-layout 
title="Editar categoría"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Categorías ',
        'route' => route('admin.categories.index')
    ],
    [
        'name' => 'Editar '.$category->name
    ]
]">
    <x-wire-card>
        <form action="{{ route('admin.categories.update', $category) }}" 
            method="POST" 
            class="space-y-4">
            @csrf
            @method('PUT')

            <x-wire-input 
                label="Nombre" 
                name="name" 
                placeholder="Nombre de la categoría"
                value="{{ old('name', $category->name) }}"
            />
            <x-wire-textarea 
                label="Descripción" 
                name="description" 
                placeholder="Ingrese una descripción a la categoría">
                {{ old('description', $category->description) }}
            </x-wire-textarea>
            <div class="flex justify-end">
                <x-button type="submit">
                    Actualizar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>