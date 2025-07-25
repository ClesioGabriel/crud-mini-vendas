<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Index extends Component
{
    public bool $showFormModal = false;
    public bool $showViewModal = false;
    public ?Customer $selectedCustomer = null;

    public $name = '';
    public $email = '';
    public $phone = '';

    #[On('customer-saved')]
    #[On('close-form-modal')]
    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->selectedCustomer = null;
    }

    public function create()
    {
        $this->selectedCustomer = null;
        $this->resetFormFields();
        $this->showFormModal = true;

        $this->showDropdown = false;
    }

    public function edit(Customer $customer)
    {
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;

        $this->selectedCustomer = $customer;
        $this->showFormModal = true;

        $this->showDropdown = false;
    }

    public function delete(Customer $customer)
    {
        $customer->delete();
        $this->dispatch('notify', 'Cliente excluído com sucesso!');

        $this->showDropdown = false;
    }

    private function resetFormFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
    }

    public function render()
    {
        return view('livewire.customers.index', [
            'customers' => Customer::latest()->paginate(10),
        ]);
    }
}
