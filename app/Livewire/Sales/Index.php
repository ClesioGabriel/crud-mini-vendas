<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Index extends Component
{
    public bool $showFormModal = false;
    public bool $showViewModal = false;
    public ?Sale $selectedSale = null;

    #[On('sale-saved')]
    #[On('close-form-modal')]
    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->selectedSale = null;
    }

    public function create()
    {
        $this->selectedSale = null;
        $this->showFormModal = true;
    }

    public function edit(Sale $sale)
    {
        $this->selectedSale = $sale;
        $this->showFormModal = true;
    }

    public function view(Sale $sale)
    {
        $this->selectedSale = $sale;
        $this->showViewModal = true;
    }

    #[On('close-view-modal')]
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedSale = null;
    }

    public function delete(Sale $sale)
    {
        $sale->delete();
        $this->dispatch('notify', 'Venda excluída com sucesso!');
    }

    public function render()
    {
        return view('livewire.sales.index', [
            'sales' => Sale::latest()->paginate(10),
        ]);
    }
}
