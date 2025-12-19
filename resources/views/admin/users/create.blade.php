<x-admin-layout 
title="Nuevo usuario"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Usuarios',
        'route' => route('admin.users.index')
    ],
    [
        'name' => 'Nuevo usuario'
    ]

]">
    <x-wire-card>
        <h1 class="text-2xl font-semibold mb-4">
            Nuevo Usuario
        </h1>

        <form action="{{ route('admin.users.store') }}" 
            method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="flex justify-start mb-4">
                <div class="relative">
                    <label for="avatar"
                        class="cursor-pointer block">
                        <div class="w-32 h-32 rounded-full border-4 border-blue-500 overflow-hidden bg-gray-200 flex items-center justify-center hover:opacity-80 transition">
                            <img id="img-preview" 
                                src=""
                                class="w-full h-full object-cover hidden">
                            <i id="icon-preview" 
                                class="fa-solid fa-camera text-3xl text-gray-500"></i>
                        </div>
                    </label>
                    <input id="avatar" 
                        type="file" 
                        name="avatar"
                        class="hidden"
                        accept="image/*"
                        onchange="previewImage(event)"
                        >
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-wire-input label="Nombre"
                    name="name"
                    required
                    placeholder="Nombre de usuario"
                    value="{{ old('name') }}">
                </x-wire-input>
                <x-wire-input label="Correo electrónico"
                    name="email"
                    type="email"
                    required
                    placeholder="Correo electrónico del usuario"
                    value="{{ old('email') }}">
                </x-wire-input>
                <x-wire-input label="Contraseña"
                    name="password"
                    type="password"
                    required
                    placeholder="Contraseña del usuario">
                </x-wire-input>
                <x-wire-input label="Confirmar contraseña"
                    name="password_confirmation"
                    type="password"
                    required
                    placeholder="Confirmar la contraseña del usuario">
                </x-wire-input>
            </div>

            <div class="flex justify-end mt-4">
                <x-button type="submit">
                    Crear usuario
                </x-button>
            </div>
        </form>
    </x-wire-card>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const imageField = document.getElementById('img-preview');
            const iconField = document.getElementById('icon-preview');

            reader.onload = function() {
                if (reader.readyState === 2) {
                    imageField.src = reader.result;
                    imageField.classList.remove('hidden');
                    iconField.classList.add('hidden');
                }
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-admin-layout>