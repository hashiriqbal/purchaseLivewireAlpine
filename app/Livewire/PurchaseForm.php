<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PurchaseForm extends Component
{
    public $items;
    public $brands;

    public $rows = [];

    public $total = 0;

    public function mount()
    {


        if (!auth()->check()) {
            abort(403);
        }

        if (!auth()->user()->user_type === 'Admin') {
            abort(403);
        }

        $this->items = Item::all();
        $this->brands = Brand::all();

        $this->rows[] = [
            'item_id' => '',
            'brand_id' => '',
            'qty' => 1,
            'price' => 0,
        ];
    }

    public function addRow()
    {
        $this->rows[] = [
            'item_id' => '',
            'brand_id' => '',
            'qty' => 1,
            'price' => 0,
        ];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);

        $this->rows = array_values($this->rows);

        $this->calculateTotal();
    }

    public function updatedRows()
    {
        $this->validateRows();
        $this->calculateTotal();
    }

    public function validateRows()
    {
        $this->validate([
            'rows.*.item_id' => 'required|exists:items,id',
            'rows.*.brand_id' => 'required|exists:brands,id',
            'rows.*.qty' => 'required|integer|min:1',
            'rows.*.price' => 'required|numeric|min:0',
        ]);

        $combinations = [];

        foreach ($this->rows as $row) {
            $key = $row['item_id'] . '-' . $row['brand_id'];

            if (in_array($key, $combinations)) {
                $this->addError('duplicate', 'Duplicate item and brand combination detected.');
                return;
            }

            $combinations[] = $key;
        }
    }

    public function calculateTotal()
    {
        $this->total = collect($this->rows)->sum(function ($row) {
            return ($row['qty'] ?? 0) * ($row['price'] ?? 0);
        });
    }

    public function save()
    {
        $this->validateRows();

        DB::transaction(function () {

            $purchase = Purchase::create([
                'total' => $this->total
            ]);

            foreach ($this->rows as $row) {

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'item_id' => $row['item_id'],
                    'brand_id' => $row['brand_id'],
                    'qty' => $row['qty'],
                    'price' => $row['price'],
                ]);
            }
        });

        session()->flash('success', 'Purchase created successfully');

        return redirect()->route('purchases.index');
    }

    public function render()
    {
        return view('livewire.purchase-form');
    }
}