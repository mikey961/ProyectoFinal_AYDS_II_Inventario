<div class="flex flex-wrap gap-1">
    @forelse ($permissions as $permission)
        <x-wire-badge sky>
            {{ $permission->name }}
        </x-wire-badge>
    @empty
        <x-wire-badge red>
            Sin permisos
        </x-wire-badge>
    @endforelse
</div>