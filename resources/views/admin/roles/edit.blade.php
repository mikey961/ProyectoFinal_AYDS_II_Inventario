<x-admin-layout
title="Editar rol"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Listado de roles',
        'route' => route('admin.roles.index')

    ],
    [
        'name' => 'Editar ' . $role->name
    ]
]">
    <x-wire-card>
        <h1 class="text-2xl font-semibold mb-4">
            Editar Rol
        </h1>

        <form action="{{ route('admin.roles.update', $role) }}" 
            method="POST"
            class="space-y-4">
            @csrf
            @method('PUT')

            <x-wire-input label="Nombre del rol"
                name="name"
                placeholder="Ingresar nombre del rol"
                value="{{ old('name', $role->name) }}"
                required
            />
            <div>
                <p class="block text-sm font-medium disabled:opacity-60 text-gray-700 dark:text-gray-400 invalidated:text-negative-600 dark:invalidated:text-negative-700">
                    Permisos
                </p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($permissions as $permission)
                        <li>
                            <label>
                                <x-checkbox name="permissions[]"
                                    value="{{ $permission->id }}"
                                    :checked="in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))"
                                />
                                <span class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $permission->name }}
                                </span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="flex justify-end">
                <x-button type="submit">
                    Actualizar rol
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>