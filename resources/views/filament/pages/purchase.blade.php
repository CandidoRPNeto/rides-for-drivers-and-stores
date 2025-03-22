<x-filament::page>
    <form wire:submit.prevent="buy" class="space-y-4">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Comprar Agora
        </x-filament::button>
    </form>
</x-filament::page>
