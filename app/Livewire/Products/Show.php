<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public Product $product;

    protected $listeners = ['closeViewModal' => 'closeModal'];

    public function closeModal()
    {
        $this->dispatch('closeViewModal');
    }

    public function render()
    {
        return view('livewire.products.show');
    }
}
