<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    /**
     * Display a listing of the resource.
     */
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
}
