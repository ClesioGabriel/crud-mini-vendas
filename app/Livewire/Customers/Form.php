<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\On;

class Form extends Component
{
    public $name;
    public $email;
    public $phone;
    public ?Customer $customer = null;

    public function mount(?Customer $customer = null)
    {
        if ($customer) {
            $this->customer = $customer;
            $this->name = $customer->name;
            $this->email = $customer->email;
            $this->phone = $customer->phone;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . ($this->customer->id ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->customer && $this->customer->exists) {
            $this->customer->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
        } else {
            Customer::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
        }

        session()->flash('success', 'Cliente salvo com sucesso!');
        $this->dispatch('customer-saved');
    }

    #[On('set-customer')]
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
    }

    public function render()
    {
        return view('livewire.customers.form');
    }
}
