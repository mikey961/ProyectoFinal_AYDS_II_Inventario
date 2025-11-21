<x-admin-layout 
title="Nueva cotización"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Cotizaciones',
        'route' => route('admin.quotes.index')
    ],
    [
        'name' => 'Nueva cotización'
    ]
]">
    @livewire('admin.quote-create')
</x-admin-layout>