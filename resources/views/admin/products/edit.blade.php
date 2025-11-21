<x-admin-layout 
title="Editar producto"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Productos',
        'route' => route('admin.products.index')
    ],
    [
        'name' => 'Editar '.$product->name
    ]
]">
    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @endpush

    <div class="mb-4">
        <form action="{{ route('admin.products.dropzone', $product) }}" 
            class="dropzone" 
            id="my-dropzone"
            method="POST">
            @csrf
        </form>
    </div>

    <x-wire-card>
        <form action="{{ route('admin.products.update', $product) }}" 
            method="POST" 
            class="space-y-4">
            @csrf
            @method('PUT')

            <x-wire-input 
                label="Nombre" 
                name="name" 
                placeholder="Nombre del producto"
                value="{{ old('name', $product->name) }}"
            />
            <x-wire-native-select label="Categoría"
                name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id}}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </x-wire-native-select>
            <x-wire-textarea 
                label="Descripción" 
                name="description" 
                placeholder="Ingrese una descripción a la categoría">
                {{ old('description', $product->description) }}
            </x-wire-textarea>
            <x-wire-input 
                label="Precio" 
                name="price" 
                placeholder="Ingrese el precio del producto"
                type="number"
                value="{{ old('price', $product->price) }}"
            />
            <div class="flex justify-end">
                <x-button type="submit">
                    Actualizar
                </x-button>
            </div>
        </form>
    </x-wire-card>

    @push('js')
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script>
            Dropzone.options.myDropzone = {
                addRemoveLinks: true,
                init: function() {
                    let myDropzone = this;
                    let images = @json($product->images);

                    images.forEach(function(image) {
                        let mockFile = {
                            id: image.id,
                            name: image.path.split('/').pop(),
                            size: image.size
                        }

                        myDropzone.displayExistingFile(mockFile, `{{ Storage::url('${image.path}') }}`);
                        myDropzone.emit("complete", mockFile);
                        myDropzone.files.push(mockFile);
                    });

                    this.on("success", function(file, response) {
                        file.id = response.id;
                    });

                    this.on("removedfile", function(file) {
                        axios.delete(`/admin/images/${file.id}`)
                            .then(response => {
                                console.log(response.data);
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    });
                }
            }
        </script>
    @endpush
</x-admin-layout>