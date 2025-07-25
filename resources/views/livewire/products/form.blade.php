<div 
    x-data="{ open: true }"
    x-show="open"
    x-on:close-form.window="open = false"
    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
>
    <div class="bg-white w-full max-w-lg rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">
            Informações do Produto
        </h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Preço</label>
                <input type="number" wire:model.defer="price" step="0.01" class="w-full border rounded px-3 py-2">
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea wire:model.defer="description" class="w-full border rounded px-3 py-2"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button 
                    type="button" 
                    x-on:click="open = false; $dispatch('close-form')"
                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-xs font-semibold rounded-full hover:bg-red-700 transition"
                >
                    Cancelar
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-xs font-semibold rounded-full hover:bg-blue-700 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>
