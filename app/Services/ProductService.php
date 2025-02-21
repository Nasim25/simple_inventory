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
                    ? '<span class="text-bold text-sm p-1 rounded-md product_active ">Active</span>'
                    : '<span class="text-sm product_inactive p-1 rounded-md">Inactive</span>'
            )
            ->addColumn(
                'action',
                fn($product) =>
                '<button class="edit btn btn-sm bg-[#792df3] text-white px-2 py-1 rounded" data-id="' . $product->id . '"><i class="fa fa-edit"></i></button>
                <button class="delete btn btn-sm bg-red-500 text-white px-2 py-1 rounded" data-id="' . $product->id . '"><i class="fa fa-trash"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function createProduct(array $data): Product
    {
        return $this->product->create($data);
    }
}
