<x-admin-layout 
title="Categorías"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Categorías'
    ]
]">
    <x-slot name="action">
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.categories.import') }}"
            sky
            rounded>
            <i class="fas fa-file-import"></i>
            Importar Categorías
        </x-wire-button>
        <x-wire-button
            class="font-semibold" 
            href="{{ route('admin.categories.create') }}"
            amber 
            rounded>
            <i class="fas fa-plus"></i>
            Nueva Categoría
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.category-table')
    </div> 
    
    @push('js')
        <script>
            forms = document.querySelectorAll('.delete-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        'icon' : 'warning',
                        'title' :'¿Estas seguro?',
                        'text' : "¡No podrás revertir esto!",
                        'confirmButtonText' : 'Sí, eliminar',
                        'confirmButtonColor' : '#3085d6',
                        'showCancelButton' : true,
                        'cancelButtonText' : 'Cancelar',
                        'cancelButtonColor' : '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-admin-layout>