<div class="flex items-center space-x-2">
    <x-wire-button href="{{ route('admin.customers.edit', $customer) }}" 
        teal 
        md 
        class="font-semibold">
        Editar
    </x-wire-button>
    <form action="{{ route('admin.customers.destroy', $customer) }}" 
        method="POST" 
        class="delete-form">
        @csrf
        @method('DELETE')

        <x-wire-button type="submit" 
            red 
            md 
            class="font-semibold">
            Eliminar
        </x-wire-button>
    </form>
</div>