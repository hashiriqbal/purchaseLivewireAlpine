<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class LegacyPurchaseMigrationService
{
    public function migrate(array $legacyPurchases)
    {
        DB::transaction(function () use ($legacyPurchases) {

            $purchase = Purchase::create([
                'total' => 0
            ]);

            $total = 0;

            foreach ($legacyPurchases as $legacy) {

                $item = Item::firstOrCreate([
                    'name' => trim($legacy['item_name'])
                ]);

                $brand = Brand::firstOrCreate([
                    'name' => trim($legacy['brand_name'])
                ]);

                $exists = PurchaseItem::where('purchase_id', $purchase->id)
                    ->where('item_id', $item->id)
                    ->where('brand_id', $brand->id)
                    ->exists();

                if (!$exists) {

                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'item_id' => $item->id,
                        'brand_id' => $brand->id,
                        'qty' => $legacy['qty'],
                        'price' => $legacy['price'],
                    ]);

                    $total += $legacy['qty'] * $legacy['price'];
                }
            }

            $purchase->update([
                'total' => $total
            ]);
        });
    }
}