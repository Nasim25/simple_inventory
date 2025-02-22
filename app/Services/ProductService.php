<?php

namespace App\Services;

use App\Models\Product;
use Yajra\DataTables\DataTables;

class ProductService
{
    public function __construct(
        private Product $product
    ) {}

    public function getAllProducts(): mixed
    {
        return DataTables::of(Product::query())
            ->editColumn(
                'status',
                fn($product) => $product->status
                    ? '<span class="text-bold text-sm p-1 rounded-md active ">Active</span>'
                    : '<span class="text-sm inactive p-1 rounded-md">Inactive</span>'
            )
            ->addColumn(
                'action',
                fn($product) =>
                '<button class="editProduct btn btn-sm bg-[#792df3] text-white px-2 py-1 rounded" data-id="' . $product->id . '"><i class="fa fa-edit"></i></button>
                <button class="deleteProduct btn btn-sm bg-red-500 text-white px-2 py-1 rounded" data-id="' . $product->id . '"><i class="fa fa-trash"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function createProduct(array $data): Product
    {
        return $this->product->create($data);
    }

    public function getProductById(int $id): Product
    {
        return $this->product->findOrFail($id);
    }

    public function updateSupplier(array $data, int $id): bool
    {
        $product = $this->getProductById($id);

        return $product->update($data);
    }

    public function deleteSupplier(int $id): bool
    {
        $product = $this->getProductById($id);

        return $product->delete();
    }
}
