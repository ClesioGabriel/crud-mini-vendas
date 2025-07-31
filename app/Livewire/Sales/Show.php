<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;

class Show extends Component
{
    public $sale;
    
    public function mount (Sale $sale)
    {
        $this->sale = $sale;
    }

    public function render()
    {
        return view('livewire.sales.show');
    }
}
