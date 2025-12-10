<x-wire-modal-card wire:model="form.open" width="lg">
    <p class="text-xl font-bold text-center mb-2">
        Enviar Correo Electrónico
    </p>
    <p class="text-lg font-normal text-left uppercase mb-2">
        {{ $form['document'] }}
    </p>
    <p class="text-xl font-normal text-left">
        {{ $form['client'] }}
    </p>

    <form wire:submit="sendEmail"
        class="mt-2">
        <x-wire-input label="Correo electrónico"
            wire:model="form.email">
        </x-wire-input>
        <x-wire-button class="w-full mt-2 font-bold"
            type="submit"
            blue>
            Enviar correo
        </x-wire-button>
    </form>
</x-wire-modal-card>