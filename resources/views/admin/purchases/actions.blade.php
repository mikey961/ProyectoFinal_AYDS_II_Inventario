<div class="flex items-center space-x-4">
    <x-wire-mini-button 
        rounded
        blue>
        <i class="fa-solid fa-envelope"></i>
    </x-wire-mini-button>
    <x-wire-mini-button 
        rounded
        red
        href="{{ route('admin.purchases.pdf', $purchase) }}">
        <i class="fa-solid fa-file-pdf"></i>
    </x-wire-mini-button>
</div>