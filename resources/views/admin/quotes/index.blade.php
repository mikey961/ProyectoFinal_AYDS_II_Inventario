<x-admin-layout 
title="Cotizaciones"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Cotizaciones'
    ]

]">
    <x-slot name="action">
        <x-wire-button class="font-semibold" 
            href="{{ route('admin.quotes.create') }}"
            amber 
            rounded>
            Nueva cotización
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.quote-table')
</x-admin-layout>