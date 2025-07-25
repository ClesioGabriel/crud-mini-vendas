<div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" wire:click.self="$set('showViewModal', false)">

    <div class="p-8 max-w-2xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-200 text-center relative z-50" wire:click.stop>
        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-6h6v6m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2h-3l-2-2H9a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Detalhes do Produto
        </h2>

        <div class="space-y-4 text-gray-700 text-lg text-left">
            <div>
                <span class="font-semibold text-gray-900">🛍️ Nome:</span> {{ $product->name }}
            </div>

            <div>
                <span class="font-semibold text-gray-900">💰 Preço:</span>
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </div>

            <div>
                <span class="font-semibold text-gray-900">📝 Descrição:</span>
                {{ $product->description ?? 'Sem descrição' }}
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('products.index') }}"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Voltar
            </a>
        </div>
    </div>

</div>
