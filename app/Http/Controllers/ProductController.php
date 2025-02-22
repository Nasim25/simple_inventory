<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Product\StoreProductRequest;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index()
    {
        return view('admin.product.index');
    }

    public function getProducts(): JsonResponse
    {
        return $this->productService->getAllProducts();
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $supplier = $this->productService->createProduct($request->validated());

        return response()->json([
            'message' => 'Product added successfully!',
            'supplier' => $supplier
        ], 201);
    }

    public function edit($id): JsonResponse
    {
        return response()->json([
            'product' => $this->productService->getProductById($id)
        ]);
    }

    public function update(StoreProductRequest $request, $supplier_id): JsonResponse
    {
        $supplier = $this->productService->updateSupplier($request->validated(), $supplier_id);

        return response()->json([
            'message' => 'Product added successfully!',
            'supplier' => $supplier
        ], 201);
    }

    public function destroy($supplier_id): JsonResponse
    {
        $this->productService->deleteSupplier($supplier_id);

        return response()->json([
            'message' => 'Product deleted successfully!'
        ], 200);
    }
}
