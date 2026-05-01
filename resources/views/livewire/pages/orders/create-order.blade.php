<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

new #[Layout('layouts.app')] class extends Component
{
    public string $product_name = '';
    
    #[On('product-changed')] 
    public function updateProductName(string $value): void
    {
        $this->product_name = $value;
    }
    
    public function save(): void
    {
        $this->redirect(route('orders'), navigate: true);
    }
}

?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-6">{{ __('Сделать новый заказ') }}</h2>
                </div>
                <livewire:pages.orders.product-input />
                <button 
                    type="button" 
                    wire:click="save"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    {{ __('Сохранить и перейти к заказам') }}
                </button>
                <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                    Введено: <span class="font-semibold text-indigo-600">{{ $product_name ?: '—' }}</span>
                </p>
                <br />
                <livewire:pages.orders.product-choose />
            </div>
        </div>
    </div>


