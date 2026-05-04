<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
//use Livewire\Js;

new #[Layout('layouts.app')] class extends Component
{
    public string $product_name = '';
    public string $notification = '';
    
    #[On('product-changed')] 
    public function updateProductName(string $value): void
    {
        $this->product_name = $value;
    }
    
    #[On('notify')] 
    public function handleNotify(array $data): void
    {
        logger('📩 handleNotify вызван!', $data);
        $json = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        $this->js(<<<JS
                console.log('🔥 JS выполняется! Данные:', {$json});
                Livewire.dispatch('show-notification', {$json});
        JS);
        
//        $this->js("window.dispatchEvent(new CustomEvent('show-notification', { detail: {$json} }));");
        
//        $type = addslashes($data['type']);
//        $message = addslashes($data['message']);
//        $timeout = $data['timeout'] ?? 3000;
//
//        $this->js(<<<JS
//            if (typeof Swal !== 'undefined') {
//                Swal.fire({
//                    icon: '{$type}',
//                    title: '{$type}' === 'success' ? '✅ Готово!' : '❌ Ошибка',
//                    text: `{$message}`,
//                    timer: {$timeout},
//                    showConfirmButton: {$type} !== 'success',
//                    toast: {$type} === 'success',
//                    position: '{$type}' === 'success' ? 'top-end' : 'center',
//                    timerProgressBar: true
//                });
//            }
//        JS);
    }
    
//    public function updatedNotification(string $value): void
//    {
//        logger('🔄 updatedNotification вызван!', $value);
//        $this->js("console.log('✅ Товар создан: родительский компонент)')");
//        if (empty($value['message'])) {
//            return;
//        }
//
//        // Экранируем для безопасной вставки в JS
//        $data = json_decode($value, true);
//        
//        $type = addslashes($data['type']);
//        $message = addslashes($data['message']);
//        $timeout = $data['timeout'] ?? 3000;
//        
//        $this->js(<<<JS
//            Swal.fire({
//                icon: '{$type}',
//                title: '{$type}' === 'success' ? '✅ Готово!' : '❌ Ошибка',
//                text: `{$message}`,
//                timer: {$timeout},
//                showConfirmButton: {$type} !== 'success',
//                toast: {$type} === 'success',
//                position: {$type} === 'success' ? 'top-end' : 'center',
//                timerProgressBar: true
//            })
//        JS);
//        
//        $this->notification = [];
//    }
    
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


