<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function __construct(
        private readonly Purchase $purchaseModel,
        private readonly PurchaseDetail $purchaseDetailModel
    ) {}

    public function getPurchasesData($request)
    {
        $query = $this->purchaseModel->with(['supplier:id,name', 'purchaseDetails'])
            ->select('purchases.*')
            ->when($request->input('supplier_id'), fn($q, $supplierId) => $q->where('supplier_id', $supplierId))
            ->when($request->input('start_date'), fn($q, $startDate) => $q->where('date', '>=', $startDate))
            ->when($request->input('end_date'), fn($q, $endDate) => $q->where('date', '<=', $endDate));

        return DataTables::of($query)
            ->addColumn('id', fn($purchase) => $purchase->formatted_id)
            ->addColumn('supplier', fn($purchase) => $purchase->supplier?->name ?? 'N/A')
            ->addColumn('total', fn($purchase) => $purchase->purchaseDetails->sum('total_price'))
            ->addColumn('paid', 0)
            ->addColumn('status', fn($purchase) => $purchase->purchaseDetails->isNotEmpty() ? 'Completed' : 'Pending')
            ->editColumn('date', fn($purchase) => $purchase->date)
            ->addColumn('notes', fn($purchase) => $purchase->notes ?? '-')
            ->addColumn('action', fn($purchase) => sprintf(
                '<a href="%s" class="btn btn-sm btn-primary">View</a>',
                route('purchase.view', $purchase->id)
            ))
            ->make(true);
    }

    public function store(array $data): Purchase
    {
        return DB::transaction(fn() => tap(
            $this->purchaseModel->create([
                'supplier_id' => $data['supplier'],
                'date' => $data['date'],
                'notes' => $data['notes'] ?? null,
            ]),
            fn($purchase) => collect($data['cart'])->each(
                fn($item) =>
                $this->purchaseDetailModel->create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['unitPrice'],
                    'total_price' => $item['totalPrice'],
                ])
            )
        ));
    }

    public function getProductById(int $purchase_id): ?Purchase
    {
        return $this->purchaseModel->with(['supplier:id,name', 'purchaseDetails.product:id,name'])
            ->find($purchase_id);
    }
}
