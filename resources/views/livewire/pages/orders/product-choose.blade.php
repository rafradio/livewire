<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Product;

new class extends Component 
{
    use WithPagination;

    public string $search = '';
    public ?int $selectedProductId = null;
    public ?string $selectedProductName = null;
    public int $perPage = 5;

    // Сброс пагинации при изменении поиска
    public function updatedSearch(): void 
    {
        $this->resetPage();
    }

    // Выбор товара
    public function selectProduct(int $id): void 
    {
        $product = Product::find($id);
        if ($product) {
            $this->selectedProductId = $product->id;
            $this->selectedProductName = $product->name;
            $this->search = '';
            $this->resetPage();
            
            // Отправляем родителю и имя, и ID (для гибкости)
            $this->dispatch('product-select', value: $product->name, id: $product->id);
        }
    }

    // Получение отфильтрованных товаров
    public function getProductsProperty()
    {
        return Product::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate($this->perPage);
    }
}; ?>

<div class="relative space-y-2">
    <!-- Выбранный товар (визуальный индикатор) -->
    <div class="flex items-center justify-between p-2 border rounded-md bg-white dark:bg-gray-800 dark:border-gray-700">
        <span class="text-sm text-gray-700 dark:text-gray-300">
            {{ $selectedProductName ?: '🔍 Выберите товар...' }}
        </span>
        @if($selectedProductId)
            <button type="button" wire:click="$set('selectedProductId', null); $set('selectedProductName', null)" class="text-gray-400 hover:text-red-500 transition">Х</button>
        @endif
    </div>

    <!-- Поле поиска -->
    <input 
        type="text" 
        wire:model.live.debounce.300ms="search"
        placeholder="Начните вводить название..." 
        class="w-full p-2 text-sm border rounded-md bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500"
    />

    <!-- Список товаров (скролл + пагинация) -->
    <div class="max-h-48 overflow-y-auto border rounded-md bg-white dark:bg-gray-800 dark:border-gray-700">
        @forelse($this->products as $product)
            <button 
                type="button" 
                wire:click="selectProduct({{ $product->id }})"
                class="w-full text-left px-3 py-2 text-sm hover:bg-indigo-50 dark:hover:bg-gray-700 flex justify-between items-center transition"
            >
                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $product->name }}</span>
                <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-600 rounded-full">{{ $product->quantity }} шт.</span>
            </button>
        @empty
            <div class="px-3 py-4 text-center text-sm text-gray-500">Товары не найдены</div>
        @endforelse
    </div>

    <!-- Пагинация -->
    <div class="px-1">
        {{ $this->products->links() }}
    </div>
</div>