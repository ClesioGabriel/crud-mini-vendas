<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $customer_id;
    public $date;
    public $items = [];
    public $total_amount = 0;
    public ?Sale $sale = null;

    public function mount(?Sale $sale = null)
    {
        if ($sale && $sale->exists) {
            $this->sale = $sale;
            $this->customer_id = $sale->customer_id;
            $this->date = $sale->date;
            $this->items = $sale->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal'   => $item->subtotal,
                ];
            })->toArray();
            $this->updateTotal();
        } else {
            $this->date = now()->format('Y-m-d');
            $this->items = [];
        }
    }

    public function rules()
    {
        return [
            'customer_id'        => 'required|exists:customers,id',
            'date'               => 'required|date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ];
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity'   => 1,
            'unit_price' => 0,
            'subtotal'   => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->updateTotal();
    }

    public function updatedItems()
    {
        foreach ($this->items as $index => $item) {
            if (!empty($item['product_id'])) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $this->items[$index]['unit_price'] = $product->price;
                    $this->items[$index]['subtotal'] = $product->price * $this->items[$index]['quantity'];
                }
            }
        }
        $this->updateTotal();
    }

    private function updateTotal()
    {
        $this->total_amount = collect($this->items)->sum('subtotal');
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            if ($this->sale && $this->sale->exists) {
                $this->sale->update([
                    'customer_id'  => $this->customer_id,
                    'date'         => $this->date,
                    'total_amount' => $this->total_amount,
                ]);
                $this->sale->items()->delete();
            } else {
                $this->sale = Sale::create([
                    'customer_id'  => $this->customer_id,
                    'date'         => $this->date,
                    'total_amount' => $this->total_amount,
                ]);
            }

            foreach ($this->items as $item) {
                $this->sale->items()->create($item);
            }
        });

        $this->dispatch('sale-saved');
    }

    public function render()
    {
        return view('livewire.sales.form', [
            'customers' => Customer::orderBy('name')->get(),
            'products'  => Product::orderBy('name')->get(),
        ]);
    }
}
