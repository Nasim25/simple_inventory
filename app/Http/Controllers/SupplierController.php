<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;

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

    public function edit(): JsonResponse
    {
        return response()->json([
            'supplier' => $this->supplierService->getSupplierById(request('id'))
        ]);
    }

    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = $this->supplierService->createSupplier($request->validated());

        return response()->json([
            'message' => 'Supplier added successfully!',
            'supplier' => $supplier
        ], 201);
    }

    public function update(UpdateSupplierRequest $request, $supplier_id): JsonResponse
    {
        $supplier = $this->supplierService->updateSupplier($request->validated(), $supplier_id);

        return response()->json([
            'message' => 'Supplier added successfully!',
            'supplier' => $supplier
        ], 201);
    }

    public function destroy($supplier_id): JsonResponse
    {
        $this->supplierService->deleteSupplier($supplier_id);

        return response()->json([
            'message' => 'Supplier deleted successfully!'
        ], 200);
    }
}
