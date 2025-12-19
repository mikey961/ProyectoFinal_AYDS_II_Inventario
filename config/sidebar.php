<?php

return $links = [
        [
            'type' => 'link',
            'title' => 'Dashboard',
            'icon' => 'fa-solid fa-chart-bar',
            'route' => 'admin.dashboard',
            'active' => 'admin.dashboard',
        ],
        [
            'type' => 'header',
            'title' => 'Principal',
        ],
        [
            'type' => 'group',
            'title' => 'Inventario',
            'icon' => 'fa-solid fa-boxes-stacked',
            'active' => [
                'admin.categories.*',
                'admin.products.*',
                'admin.warehouses.*'
            ],
            'items' => [
                [
                    'type' => 'link',
                    'title' => 'Categorías',
                    'icon' => 'fa-solid fa-list',
                    'route' => 'admin.categories.index',
                    'active' => 'admin.categories.*'
                ],
                [
                    'type' => 'link',
                    'title' => 'Productos',
                    'icon' => 'fa-solid fa-box',
                    'route' => 'admin.products.index',
                    'active' => 'admin.products.*'
                ],
                [
                    'type' => 'link',
                    'title' => 'Almacenes',
                    'icon' => 'fa-solid fa-warehouse',
                    'route' => 'admin.warehouses.index',
                    'active' => 'admin.warehouses.*'
                ]
            ]
        ],
        [
            'type' => 'group',
            'title' => 'Compras',
            'icon' => 'fa-solid fa-shop',
            'active' => [
                'admin.suppliers.*',
                'admin.purchase-orders.*',
                'admin.purchases.*'
            ],
            'items' => [
                [
                    'type' => 'link',
                    'title' => 'Proveedores',
                    'icon' => 'fa-solid fa-truck',
                    'route' => 'admin.suppliers.index',
                    'active' => 'admin.suppliers.*'
                ],
                [
                    'type' => 'link',
                    'title' => 'Ordenes de compra',
                    'icon' => 'fa-solid fa-boxes-packing',
                    'route' => 'admin.purchase-orders.index',
                    'active' => 'admin.purchase-orders.*'
                ],
                [
                    'type' => 'link',
                    'title' => 'Compras',
                    'icon' => 'fa-solid fa-cart-shopping',
                    'route' => 'admin.purchases.index',
                    'active' => 'admin.purchases.*'
                ]
            ]
        ],
        [
            'type' => 'group',
            'title' => 'Ventas',
            'icon' => 'fa-solid fa-basket-shopping', 
            'active' => [
                'admin.customers.*',
                'admin.quotes.*',
                'admin.sales.*'
            ],
            'items' => [
                [
                    'type' => 'link',
                    'title' => 'Clientes',
                    'icon' => 'fa-solid fa-users',
                    'route' => 'admin.customers.index',
                    'active' => 'admin.customers.*'
                ],
                [
                    'type' => 'link',
                    'title' => 'Cotizaciones',
                    'icon' => 'fa-solid fa-file-pen',
                    'route' => 'admin.quotes.index',
                    'active' => 'admin.quotes.*'
                ],
                [
                    'type' => 'link',
                    'title' => 'Ventas',
                    'icon' => 'fa-solid fa-cart-shopping',
                    'route' => 'admin.sales.index',
                    'active' => 'admin.sales.*'
                ]
            ]
        ],
        [
            'type' => 'group',
            'title' => 'Movimientos',
            'icon' => 'fa-solid fa-sync',
            'active' => [
                'admin.movements.*',
                'admin.transfers.*'
            ],
            'items' => [
                [
                    'type' => 'link',
                    'title' => 'Entradas y Salidas',
                    'icon' => 'fa-solid fa-arrow-right-arrow-left',
                    'route' => 'admin.movements.index',
                    'active' => 'admin.movements.*'
                ],
                [
                    'type' => 'link',
                    'title' => 'Transferencias',
                    'icon' => 'fa-solid fa-building-columns',
                    'route' => 'admin.transfers.index',
                    'active' => 'admin.transfers.*'
                ]
            ]
        ],
        [
            'type' => 'group',
            'title' => 'Reportes',
            'icon' => 'fa-solid fa-chart-line',
            'active' => [
                'admin.reports.top-products',
                'admin.reports.top-customers'
            ],
            'items' => [
                [
                    'type' => 'link',
                    'title' => 'Productos más vendidos',
                    'icon' => 'fa-solid fa-fire-flame-curved',
                    'route' => 'admin.reports.top-products',
                    'active' => 'admin.reports.top-products'
                ],
                [
                    'type' => 'link',
                    'title' => 'Clientes con más frecuencia',
                    'icon' => 'fa-solid fa-award',
                    'route' => 'admin.reports.top-customers',
                    'active' => 'admin.reports.top-customers'
                ]
            ]
        ],
        [
            'type' => 'header',
            'title' => 'Configuraciones'
        ],
        [
            'type' => 'link',
            'title' => 'Usuarios',
            'icon' => 'fa-solid fa-user',
            'route' => 'admin.users.index',
            'active' => 'admin.users.*'
        ],
        [
            'type' => 'link',
            'title' => 'Roles',
            'icon' => 'fa-solid fa-id-badge',
            'route' => 'admin.roles.index',
            'active' => 'admin.roles.*'
        ],
    ];