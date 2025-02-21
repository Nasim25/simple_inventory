<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreSupplierRequest;

class SupplierController extends Controller
{

    public function __construct(
        private SupplierService $supplierService
    ) {}

    public function index()
    {
        return view('admin.supplier.index');
    }

    public function getSuppliers(): JsonResponse
    {
        return $this->supplierService->getAllSuppliers();
    }

    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = $this->supplierService->createSupplier($request->validated());

        return response()->json([
            'message' => 'Supplier added successfully!',
            'supplier' => $supplier
        ], 201);
    }
}
