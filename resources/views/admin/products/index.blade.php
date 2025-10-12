<x-admin-layout
title="Productos"
:breadcrumbs="[
    [
        'name' => 'Inventario'
    ],
    [
        'name' => 'Productos'
    ]
]">

    @push('css')
        <style>
            table td {
                white-space: normal !important;
                word-wrap: break-word;
                overflow-wrap: break-word;
                max-width: 400px;
            }

            table th {
                white-space: nowrap;
            }

            table {
                table-layout: auto;
            }

            .image-product {
                width: 5rem;
                height: 3.5rem;
                object-fit: cover;
                object-position: center;
            }
        </style>
    @endpush

    <x-slot name="action">
        <x-wire-button
        class="font-semibold" 
        href="{{ route('admin.products.create') }}"
        amber 
        rounded>
            Nuevo Producto
        </x-wire-button>
    </x-slot>
    
    <div class="mt-4">
        @livewire('admin.datatables.product-table')
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