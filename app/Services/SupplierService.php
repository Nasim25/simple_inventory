<?php

namespace App\Services;

use App\Models\Supplier;
use Yajra\DataTables\DataTables;

class SupplierService
{
    public function __construct(
        private Supplier $supplier
    ) {}

    public function getAllSuppliers(): mixed
    {
        return DataTables::of(Supplier::query())
            ->editColumn(
                'status',
                fn($supplier) => $supplier->status
                    ? '<span class="text-bold text-sm p-1 rounded-md bg-blue-500 ">Active</span>'
                    : '<span class="text-white text-sm bg-red-500 p-1 rounded-md">Inactive</span>'
            )
            ->addColumn(
                'action',
                fn($supplier) =>
                '<button class="edit btn btn-sm bg-[#792df3] text-white px-2 py-1 rounded" data-id="' . $supplier->id . '"><i class="fa fa-edit"></i></button>
                <button class="delete btn btn-sm bg-red-500 text-white px-2 py-1 rounded" data-id="' . $supplier->id . '"><i class="fa fa-trash"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function createSupplier(array $data): Supplier
    {
        return $this->supplier->create($data);
    }
}
