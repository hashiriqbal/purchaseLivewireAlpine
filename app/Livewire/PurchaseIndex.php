<?php

namespace App\Livewire;

use App\Models\Purchase;
use Livewire\Component;

class PurchaseIndex extends Component
{
    public function render()
    {
        return view('livewire.purchase-index', [
            'purchases' => Purchase::with('purchaseItems.item', 'purchaseItems.brand')->latest()->get()
        ]);
    }
}