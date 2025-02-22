<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseDetail;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePurchaseRequest;

class PurchaseController extends Controller
{
    public function __construct(private readonly PurchaseService $purchaseService) {}

    public function index()
    {
        $data['suppliers'] = Supplier::where('status', 1)->get();
        return view('admin.purchase.index', $data);
    }

    public function getPurchases(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            return $this->purchaseService->getPurchasesData($request);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function create()
    {
        $data['products'] = Product::where('status', 1)->get();
        $data['suppliers'] = Supplier::where('status', 1)->get();
        return view('admin.purchase.create', $data);
    }

    public function store(StorePurchaseRequest $request): JsonResponse
    {
        try {
            $purchase = $this->purchaseService->store($request->validated());
            return response()->json(['message' => 'Purchase saved successfully', 'data' => $purchase], 201);
        } catch (Throwable $e) {
            return match (true) {
                str_contains($e->getMessage(), 'Duplicate entry') =>
                response()->json(['message' => 'Duplicate purchase detected.'], 409),
                default =>
                response()->json(['message' => 'Error: ' . $e->getMessage()], 500),
            };
        }
    }

    public function getProductById($id)
    {
        $purchases = $this->purchaseService->getProductById($id);
        
        return view('admin.purchase.view', compact('purchases'));
    }
}
