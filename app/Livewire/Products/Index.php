<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Index extends Component
{
    public bool $showFormModal = false;
    public bool $showViewModal = false;
    public ?Product $selectedProduct = null;

    public $name = '';
    public $price = '';
    public $description = '';

    #[On('product-saved')]
    #[On('close-form-modal')]
    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->selectedProduct = null;
    }

    public function create()
    {
        $this->selectedProduct = null;
        $this->resetFormFields();
        $this->showFormModal = true;

        $this->showDropdown = false;
    }

    public function edit(Product $product)
    {
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;

        $this->selectedProduct = $product;
        $this->showFormModal = true;

        $this->showDropdown = false;
    }

    public function view(Product $product)
    {
        $this->selectedProduct = $product;
        $this->showViewModal = true;
    }

    #[On('close-view-modal')]
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedProduct = null;
    }

    public function delete(Product $product)
    {
        $product->delete();
        $this->dispatch('notify', 'Produto excluído com sucesso!');
    }

    private function resetFormFields()
    {
        $this->name = '';
        $this->price = '';
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.products.index', [
            'products' => Product::latest()->paginate(10),
        ]);
    }
}
