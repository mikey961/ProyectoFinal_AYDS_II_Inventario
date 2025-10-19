<x-admin-layout 
title="Nueva proveedor"
:breadcrumbs="[
    [
        'name' => 'Compras'
    ],
    [
        'name' => 'Proveedores',
        'route' => route('admin.suppliers.index')
    ],
    [
        'name' => 'Nuevo proveedor'
    ]
]">
    <x-wire-card>
        <form action="{{ route('admin.suppliers.store') }}" 
            method="POST" 
            class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <x-wire-native-select label="Tipo de documento"
                    name="identity_id">
                    @foreach ($identities as $identity)
                        <option value="{{ $identity->id }}" 
                            @selected(old('identity_id') == $identity->id)>
                            {{ $identity->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>
                <x-wire-input 
                label="Numero de documento" 
                name="document_number" 
                placeholder="Numero de documento"
                value="{{ old('document_number') }}"/>
            </div>
            <x-wire-input 
                label="Nombre" 
                name="name" 
                placeholder="Nombre del proveedor"
                value="{{ old('name') }}"
            />
            <x-wire-input 
                label="Dirección" 
                name="address" 
                placeholder="Dirección del proveedor"
                value="{{ old('address') }}"
            />
            <x-wire-input 
                label="Correo" 
                name="email" 
                placeholder="Correo electrónico del proveedor"
                type="email"
                value="{{ old('email') }}"
            />
            <x-wire-input 
                label="Teléfono" 
                name="phone" 
                placeholder="Numero de teléfono del proveedor"
                type="text"
                value="{{ old('phone') }}"
                pattern="[\d\+\-\(\)\s]+"
                inputmode="tel"
            />
            <div class="flex justify-end">
                <x-button type="submit">
                    Guardar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>