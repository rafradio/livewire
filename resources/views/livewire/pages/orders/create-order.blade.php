<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component
{
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
                <button 
                    type="button" 
                    wire:click="save"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    {{ __('Сохранить и перейти к заказам') }}
                </button>
            </div>
        </div>
    </div>


