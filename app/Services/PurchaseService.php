<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function __construct(
        private readonly Purchase $purchaseModel,
        private readonly PurchaseDetail $purchaseDetailModel
    ) {}

    public function store(array $data): Purchase
    {
        return DB::transaction(function () use ($data) {
            $purchase = $this->purchaseModel->create([
                'supplier_id' => $data['supplier'],
                'date' => $data['date'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['cart'] as $item) {
                $this->purchaseDetailModel->create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['unitPrice'],
                    'total_price' => $item['totalPrice'],
                ]);
            }

            return $purchase;
        });
    }
}
