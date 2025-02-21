<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PurchaseService
{
    public function __construct(
        private readonly Purchase $purchaseModel,
        private readonly PurchaseDetail $purchaseDetailModel
    ) {}

    public function getPurchasesData()
    {
        $query = $this->purchaseModel->with('supplier', 'purchaseDetails')
            ->select('purchases.*');

        return DataTables::of($query)
            ->addColumn('id', function ($purchase) {
                return $purchase->formatted_id;
            })
            ->addColumn('supplier', function ($purchase) {
                return $purchase->supplier->name ?? 'N/A';
            })
            ->addColumn('total', function ($purchase) {
                return $purchase->purchaseDetails->sum('total_price');
            })
            ->addColumn('paid', 0)
            ->addColumn('status', function ($purchase) {
                return $purchase->purchaseDetails->count() > 0 ? 'Completed' : 'Pending';
            })
            ->editColumn('date', function ($purchase) {
                return $purchase->date;
            })
            ->addColumn('notes', function ($purchase) {
                return $purchase->notes ?? '-';
            })
            ->addColumn(
                'action',
                fn($purchase) =>
                '<button class="edit btn btn-sm bg-[#792df3] text-white px-2 py-1 rounded" data-id="' . $purchase->id . '"><i class="fa fa-edit"></i></button>
                <button class="delete btn btn-sm bg-red-500 text-white px-2 py-1 rounded" data-id="' . $purchase->id . '"><i class="fa fa-trash"></i></button>'
            )
            ->make(true);
    }

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
