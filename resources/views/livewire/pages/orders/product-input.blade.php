<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component
{
    public string $value = '';
    public int $quantity = 1;
    public string $label = 'Название товара';
    public string $placeholder = 'Введите название товара';   

    public function getValue(): string
    {
        return $this->value;
    }
    
    public function updatedValue(): void
    {
        $this->js("console.log('🔄 Child value: {$this->value}')");
        logger('Товар: ' . $this->value);
        $this->dispatch('product-changed', value: $this->value); 
    }
    
    public function save(): void
    {
        $validated = $this->validate([
            'value' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::create([
            'name' => $validated['value'],
            'quantity' => $validated['quantity'],
        ]);

        $this->dispatch('product-created', id: $product->id, name: $product->name, quantity: $product->quantity);

        $this->reset(['value', 'quantity']);

        $this->js("console.log('✅ Товар создан: {$product->name} ({$product->quantity} шт.)')");
    }
    
}; ?>

<form wire:submit="save" class="space-y-4" style="margin-bottom: 20px;">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ __('Название товара') }}
        </label>
        <input
            type="text"
            wire:model.live.debounce.500ms="value"
            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
            placeholder="{{ __($this->placeholder) }}"
        />
        @error('value') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ __('Количество') }}
        </label>
        <input
            type="number"
            wire:model.live="quantity"
            min="1"
            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
        />
        @error('quantity') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>
    <button
        type="submit"
        wire:loading.attr="disabled"
        wire:target="save"
        class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition"
    >
        <span wire:loading.remove wire:target="save">{{ __('Добавить товар') }}</span>
        <span wire:loading wire:target="save" class="inline-flex items-center">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            Сохранение...
        </span>
    </button>
</form>