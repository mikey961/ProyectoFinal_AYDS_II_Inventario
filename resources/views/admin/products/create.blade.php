<x-admin-layout 
title="Nuevo producto"
:breadcrumbs="[
    [
        'name' => 'Inventario'
    ],
    [
        'name' => 'Productos',
        'route' => route('admin.products.index')
    ],
    [
        'name' => 'Nuevo producto'
    ]
]">
    <x-wire-card>
        <form action="{{ route('admin.products.store') }}" 
            method="POST" 
            class="space-y-4">
            @csrf

            <x-wire-native-select label="Categoría"
                name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id}}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </x-wire-native-select>
            <x-wire-input 
                label="Nombre" 
                name="name" 
                placeholder="Nombre del producto"
                value="{{ old('name') }}"
            />
            <x-wire-textarea 
                label="Descripción" 
                name="description" 
                placeholder="Ingrese una descripción a la categoría">
                {{ old('description') }}
            </x-wire-textarea>
            <x-wire-input 
                label="Precio" 
                name="price" 
                placeholder="Ingrese el precio del producto"
                type="number"
                value="{{ old('price') }}"
            />
            <div class="flex justify-end">
                <x-button type="submit">
                    Guardar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>