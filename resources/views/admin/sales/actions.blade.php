<div class="flex items-center space-x-4">
    <x-wire-mini-button 
        rounded
        blue
        wire:click="openModal({{ $sale->id }})">
        <i class="fa-solid fa-envelope"></i>
    </x-wire-mini-button>
    <x-wire-mini-button 
        rounded
        red
        href="{{ route('admin.sales.pdf', $sale) }}">
        <i class="fa-solid fa-file-pdf"></i>
    </x-wire-mini-button>
</div>