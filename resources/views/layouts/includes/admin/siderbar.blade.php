@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-chart-bar',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'header' => 'Principal',
        ],
        [
            'name' => 'Inventario',
            'icon' => 'fa-solid fa-boxes-stacked',
            'active' => request()->routeIs([
                'admin.categories.*',
                'admin.products.*',
                'admin.warehouses.*'
            ]),
            'submenu' => [
                [
                    'name' => 'Categorías',
                    'icon' => 'fa-solid fa-list',
                    'route' => route('admin.categories.index'),
                    'active' => request()->routeIs('admin.categories.*')
                ],
                [
                    'name' => 'Productos',
                    'icon' => 'fa-solid fa-box',
                    'route' => route('admin.products.index'),
                    'active' => request()->routeIs('admin.products.*')
                ],
                [
                    'name' => 'Almacenes',
                    'icon' => 'fa-solid fa-warehouse',
                    'route' => route('admin.warehouses.index'),
                    'active' => request()->routeIs('admin.warehouses.*')
                ]
            ]
        ],
        [
            'name' => 'Compras',
            'icon' => 'fa-solid fa-shop',
            'active' => request()->routeIs([
                'admin.suppliers.*',
                'admin.purchase-orders.*'
            ]),
            'submenu' => [
                [
                    'name' => 'Proveedores',
                    'icon' => 'fa-solid fa-truck',
                    'route' => route('admin.suppliers.index'),
                    'active' => request()->routeIs('admin.suppliers.*')
                ],
                [
                    'name' => 'Ordenes de compra',
                    'icon' => 'fa-solid fa-boxes-packing',
                    'route' => route('admin.purchase-orders.index'),
                    'active' => request()->routeIs('admin.purchase-orders.*')
                ],
                [
                    'name' => 'Compras',
                    'icon' => 'fa-solid fa-cart-shopping',
                    'route' => '',
                    'active' => false
                ]
            ]
        ],
        [
            'name' => 'Ventas',
            'icon' => 'fa-solid fa-basket-shopping', 
            'active' => request()->routeIs([
                'admin.customers.*'
            ]),
            'submenu' => [
                [
                    'name' => 'Clientes',
                    'icon' => 'fa-solid fa-users',
                    'route' => route('admin.customers.index'),
                    'active' => request()->routeIs('admin.customers.*')
                ],
                [
                    'name' => 'Cotizaciones',
                    'icon' => 'fa-solid fa-file-pen',
                    'route' => '',
                    'active' => false
                ],
                [
                    'name' => 'Ventas',
                    'icon' => 'fa-solid fa-cart-shopping',
                    'route' => '',
                    'active' => false
                ]
            ]
        ],
        [
            'name' => 'Movimientos',
            'icon' => 'fa-solid fa-sync',
            'active' => false,
            'submenu' => [
                [
                    'name' => 'Entradas y Salidas',
                    'icon' => 'fa-solid fa-arrow-right-arrow-left',
                    'route' => '',
                    'active' => false
                ],
                [
                    'name' => 'Transferencias',
                    'icon' => 'fa-solid fa-building-columns',
                    'route' => '',
                    'active' => false
                ]
            ]
        ],
        [
            'name' => 'Reportes',
            'icon' => 'fa-solid fa-chart-line',
            'route' => '',
            'active' => false
        ],
        [
            'header' => 'Configuraciones'
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'fa-solid fa-user',
            'route' => '',
            'active' => false
        ],
        [
            'name' => 'Roles',
            'icon' => 'fa-solid fa-id-badge',
            'route' => '',
            'active' => false
        ],
        [
            'name' => 'Permisos',
            'icon' => 'fa-solid fa-key',
            'route' => '',
            'active' => false
        ],
        [
            'name' => 'Ajustes',
            'icon' => 'fa-solid fa-gear',
            'route' => '',
            'active' => false
        ],
    ];
@endphp

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-blue-900 border-r border-gray-100 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-900">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-2 py-2 text-xs text-white font-semibold uppercase opacity-80">
                            {{ $link['header'] }}
                        </div>
                    @else
                        @isset($link['submenu'])
                            <div x-data="{
                                open: {{ $link['active'] ? 'true' : 'false' }}
                            }">
                                <button type="button"
                                    @click= "open = !open"
                                    class="flex items-center w-full p-2 text-base text-white transition duration-75 rounded-lg group hover:bg-blue-500">
                                    <span class="w-6 h-6 inline-flex justify-center items-center text-white">
                                        <i class="{{ $link['icon'] }}"></i>
                                    </span>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap font-bold">
                                        {{ $link['name'] }}
                                    </span>
                                    <i class="text-sm" :class="{
                                        'fa-solid fa-chevron-up' : open,
                                        'fa-solid fa-chevron-down' : !open,
                                    }"></i>
                                </button>
                                <ul x-show="open" x-cloak class="py-2 space-y-2">
                                    @foreach ($link['submenu'] as $item)
                                        <li>
                                            <a href="{{ $item['route'] }}"
                                                class="flex items-center gap-2 w-full p-2 text-white transition duration-75 rounded-lg pl-11 group hover:bg-blue-500 {{ $item['active'] ? 'bg-blue-500' : '' }}">
                                                <span class="w-6 h-6 inline-flex justify-center items-center text-white">
                                                    <i class="{{ $item['icon'] }}"></i>
                                                </span>
                                                <div class="text-left">
                                                    {{ $item['name'] }}
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $link['route'] }}"
                                class="flex items-center p-2 rounded-lg dark:text-black hover:bg-blue-500 {{ $link['active'] ? 'bg-blue-500' : '' }}">
                                <span class="w-6 h-6 inline-flex justify-center items-center text-white">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="ms-3 font-bold text-white">
                                    {{ $link['name'] }}
                                </span>
                            </a>
                        @endisset
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>
