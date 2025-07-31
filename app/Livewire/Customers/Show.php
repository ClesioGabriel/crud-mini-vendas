<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class Show extends Component
{
    public Customer $customer;

    protected $listeners = ['closeViewModal' => 'closeModal'];

    public function closeModal()
    {
        $this->dispatch('closeViewModal');
    }

    public function render()
    {
        return view('livewire.customers.show');
    }
}
