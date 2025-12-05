<div>
    <x-wire-card>
        <x-wire-alert title="Producto Seleccionado" info >
            <x-slot name="slot" class="italic">
                <p>
                    <span class="font-bold">Nombre: </span>
                    {{ $product->name }}
                </p>
                <p>
                    <span class="font-bold">SKU: </span>
                    {{ $product->sku ?? 'No definido' }}
                </p>
                <p>
                    <span class="font-bold">Stock Total: </span>
                    {{ $product->stock }}
                </p>
            </x-slot>
        </x-wire-alert>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <x-wire-input label="Fecha incial"
                wire:model.live="fecha_inicial"
                type="date">
            </x-wire-input>
            <x-wire-input label="Fecha final"
                wire:model.live="fecha_final"
                type="date">
            </x-wire-input>
        </div>
        <x-wire-select label="Almacén"
            class="col-span-2 mt-4"
            wire:model.live="warehouse_id"
            :options="$warehouses"
            option-label="name"
            option-description="location"
            option-value="id">
            
        </x-wire-select>

        <h2 class="text-lg font-semibold text-gray-950 mt-4 mb-4">
            Kardex del producto
        </h2>

        @if ($inventories->count())
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-md">
                <table class="min-w-full bg-slate-400 text-sm text-gray-800">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center text-white text-lg font-bold" rowspan="2">
                                Detalle
                            </th>
                            <th class="px-4 py-2 text-center bg-green-300 text-green-800 text-lg font-bold" colspan="3">
                                Entradas
                            </th>
                            <th class="px-4 py-2 text-center bg-red-300 text-red-800 text-lg font-bold" colspan="3">
                                Salidas
                            </th>
                            <th class="px-4 py-2 text-center bg-blue-300 text-blue-800 text-lg font-bold" colspan="3">
                                Balance
                            </th>
                            <th class="px-4 py-2 text-center text-white text-lg font-bold" rowspan="2">
                                Fecha
                            </th>
                        </tr>
                        <tr class="text-black">
                            <th class="px-2 py-1 text-center bg-green-100">
                                Cantidad
                            </th>
                            <th class="px-2 py-1 text-center bg-green-100">
                                Costo
                            </th>
                            <th class="px-2 py-1 text-center bg-green-100">
                                Total
                            </th>
                            <th class="px-2 py-1 text-center bg-red-100">
                                Cantidad
                            </th>
                            <th class="px-2 py-1 text-center bg-red-100">
                                Costo
                            </th>
                            <th class="px-2 py-1 text-center bg-red-100">
                                Total
                            </th>
                            <th class="px-2 py-1 text-center bg-blue-100">
                                Cantidad
                            </th>
                            <th class="px-2 py-1 text-center bg-blue-100">
                                Costo
                            </th>
                            <th class="px-2 py-1 text-center bg-blue-100">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                            <tr>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->detail }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->quantity_in }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->cost_in }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->total_in }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->quantity_out }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->cost_out }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->total_out }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->quantity_balance }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->cost_balance }}
                                </td>
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->total_balance }}
                                <td class="px-4 py-2 text-center bg-white font-medium">
                                    {{ $inventory->created_at->format('d-m-y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $inventories->links() }}
            </div>
        @else
            <div class="flex flex-col items-center mt-4">
                <p class="text-lg font-semibold text-center">No hay registros de inventario</p>
                <p class="text-sm text-gray-500">Todavía no se han registrado entradas o salidas de productos en almacén seleccionado </p>
            </div>
        
        @endif
    </x-wire-card>

    
</div>