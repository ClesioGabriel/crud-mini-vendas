<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class Form extends Component
{
    public $name;
    public $price;
    public $description;
    public ?Product $product = null;

    public function mount(?Product $product = null)
    {
        if ($product) {
            $this->product = $product;
            $this->name = $product->name;
            $this->price = $product->price;
            $this->description = $product->description;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->product && $this->product->exists) {
            $this->product->update([
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
            ]);
        } else {
            Product::create([
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
            ]);
        }

        session()->flash('success', 'Produto salvo com sucesso!');
        $this->dispatch('product-saved');
    }

    #[On('set-product')]
    public function setProduct(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;
    }

    public function render()
    {
        return view('livewire.products.form');
    }
}
