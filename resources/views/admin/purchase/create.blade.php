<x-app-layout>
    <div class="min-h-screen p-4 md:p-6 lg:p-8">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Purchase Create</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Product Information</h2>
                    <hr class="p-2" />

                    <div class="grid grid-cols-12 gap-4 mb-6">
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product <span class="text-red-500">*</span></label>
                            <select id="product" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Search Name of Product</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-name="{{ $product->name }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-6 md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Qty <span class="text-red-500">*</span></label>
                            <input type="number" id="qty" placeholder="Qty" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div class="col-span-6 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price <span class="text-red-500">*</span></label>
                            <input type="number" id="unitPrice" placeholder="Unit Price" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div class="col-span-12 md:col-span-1 flex items-end">
                            <button id="addProduct" class="w-full bg-purple-600 text-white p-2 rounded-md hover:bg-purple-700 transition-colors">+</button>
                        </div>
                    </div>

                    <hr class="p-2" />
                    <!-- Table -->
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200" id="productTable">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">S/L</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Item Details</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Qty</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Unit Price</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Total Price</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Dynamic Rows Will Be Added Here -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-start space-x-4">
                        <button id="savePurchase" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">Save</button>
                    </div>
                </div>
            </div>

            <!-- Other Information Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Other Information</h2>
                    <hr class="p-2" />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                        <select id="supplier" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Search Name of Supplier</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <input type="text" id="notes" placeholder="Enter Notes" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let cart = [];

            // Add Product
            $("#addProduct").click(function() {
                let productId = $("#product").val();
                let productName = $("#product option:selected").data("name");
                let qty = $("#qty").val();
                let unitPrice = $("#unitPrice").val();
                let totalPrice = qty * unitPrice;

                if (productId && qty > 0 && unitPrice > 0) {
                    cart.push({
                        id: productId,
                        name: productName,
                        qty,
                        unitPrice,
                        totalPrice
                    });

                    let row = `
                        <tr>
                            <td>${cart.length}</td>
                            <td>${productName}</td>
                            <td>${qty}</td>
                            <td>${unitPrice}</td>
                            <td>${totalPrice}</td>
                            <td><button class="text-red-500 hover:text-red-700 removeProduct">X</button></td>
                        </tr>
                    `;

                    $("#productTable tbody").append(row);
                }
            });

            // Remove Product
            $(document).on("click", ".removeProduct", function() {
                let rowIndex = $(this).closest("tr").index();
                cart.splice(rowIndex, 1);
                $(this).closest("tr").remove();
            });

            // Save Data
            $("#savePurchase").click(function() {
                let supplier = $("#supplier").val();
                let date = $("#date").val();
                let notes = $("#notes").val();

                $.ajax({
                    url: "{{ route('purchase.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        supplier,
                        date,
                        notes,
                        cart
                    },
                    success: function(response) {
                        alert("Purchase Saved Successfully!");
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });
        });
    </script>
</x-app-layout>