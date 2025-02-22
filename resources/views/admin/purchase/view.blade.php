<x-app-layout>

    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center my-6">
            <h1 class="text-2xl font-semibold text-gray-800">Purchase Orders Details</h1>
        </div>

        <div class=" bg-white rounded-lg shadow-sm p-6">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print
            </button>
            <hr class="my-6" />
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div>
                    <p class="text-gray-600">Supplier: <span class="font-semibold text-gray-800">{{ $purchases->supplier->name }}</span></p>
                </div>
                <div>
                    <p class="text-gray-600">ORDER NO: <span class="font-semibold text-gray-800">{{ $purchases->formatted_id }}</span></p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">DATE: <span class="font-semibold text-gray-800">{{ $purchases->date }}</span></p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-black text-left text-sm font-semibold text-gray-600">S/L</th>
                            <th class="px-4 py-2 border border-black text-left text-sm font-semibold text-gray-600">Brand</th>
                            <th class="px-4 py-2 border border-black text-left text-sm font-semibold text-gray-600">Category</th>
                            <th class="px-4 py-2 border border-black text-left text-sm font-semibold text-gray-600">Product</th>
                            <th class="px-4 py-2 border border-black text-left text-sm font-semibold text-gray-600">Code</th>
                            <th class="px-4 py-2 border border-black text-left text-sm font-semibold text-gray-600">Unit</th>
                            <th class="px-4 py-2 border border-black text-right text-sm font-semibold text-gray-600">Pur. Unit Price</th>
                            <th class="px-4 py-2 border border-black text-right text-sm font-semibold text-gray-600">Quantity</th>
                            <th class="px-4 py-2 border border-black text-right text-sm font-semibold text-gray-600">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases->purchaseDetails as $item)
                        <tr>
                            <td class="px-4 py-2 border border-black text-sm">{{ $item->id }}</td>
                            <td class="px-4 py-2 border border-black text-sm">-</td>
                            <td class="px-4 py-2 border border-black text-sm">-</td>
                            <td class="px-4 py-2 border border-black text-sm">{{ $item->product->name }}</td>
                            <td class="px-4 py-2 border border-black text-sm">-</td>
                            <td class="px-4 py-2 border border-black text-sm">-</td>
                            <td class="px-4 py-2 border border-black text-sm text-right">{{ $item->unit_price }}</td>
                            <td class="px-4 py-2 border border-black text-sm text-right">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 border border-black text-sm text-right">{{ $item->total_price }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="px-4 py-2 border border-black text-right font-semibold">Total</td>
                            <td class="px-4 py-2 border border-black text-right font-semibold">{{ $purchases->purchaseDetails->sum('quantity') }}</td>
                            <td class="px-4 py-2 border border-black text-right font-semibold">{{ $purchases->purchaseDetails->sum('total_price') }}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="px-4 py-2 border border-black text-right font-semibold">Payment</td>
                            <td class="px-4 py-2 border border-black text-right font-semibold"></td>
                            <td class="px-4 py-2 border border-black text-right font-semibold">0.00</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="px-4 py-2 border border-black text-right font-semibold">Due</td>
                            <td class="px-4 py-2 border border-black text-right font-semibold"></td>
                            <td class="px-4 py-2 border border-black text-right font-semibold">{{ $purchases->purchaseDetails->sum('total_price') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-8">
                <div>
                    <p class="font-semibold mb-8">Warehouse</p>
                    <p class="font-semibold">Created By</p>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Checked By</p>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>