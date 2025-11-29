<x-wire-modal-card title="Stock por almacén" wire:model="openModal">
    <ul class="flex flex-col gap-3 p-4">
        @forelse ($inventories as $inventory)
            <li class="flex items-center justify-between p-4 bg-gray-100 rounded-lg shadow-sm">
                <div>
                    <p class="text-sm text-gray-600">
                        {{ $inventory->warehouse->name }}
                    </p>
                    <p class="font-medium text-gray-800">
                        {{ $inventory->warehouse->location }}
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500">
                        Stock disponible
                    </p>
                    <p class="text-lg font-bold {{ $inventory->quantity_balance > 5 ? 'text-green-600' : 'text-red-600'}}">
                        {{ $inventory->quantity_balance }}
                    </p>
                </div>
            </li>
        @empty
            <li class="text-center text-lg font-bold text-black py-6">
                No hay inventario de productos disponible
            </li>
        @endforelse
    </ul>
</x-wire-modal-card>