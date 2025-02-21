<x-app-layout>

    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dataTables_length select {
            width: 60px;
        }

        .product_active {
            background-color: #2ea745;
            padding: 2px 5px 2px 5px;
            color: white;
            font-weight: bold;
        }

        .product_inactive {
            background-color: red;
            padding: 2px 5px 2px 5px;
            color: white;
            font-weight: bold;
        }
    </style>

    <div class="max-w-7xl mx-auto mt-10">
        <h1 class="text-2xl font-semibold mb-6">Purchase Orders</h1>

        <div class="bg-white p-5 rounded-lg shadow overflow-hidden">
            <!-- Top Controls -->
            <div class="flex flex-wrap justify-between items-center mb-4">
                <a href="{{route('purchase.create')}}" class="bg-[#792df3] px-4 py-2 text-white rounded-md hover:bg-purple-700">Create Purchase +</a>
            </div>
            <hr class="p-5" />

            <!-- Table Controls -->
            <div class="flex flex-wrap gap-4 mb-4 items-center">
                <div class="grid grid-cols-12 gap-4 mb-6">
                    <div class="col-span-6 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                        <select id="product" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Search Name of Product</option>

                        </select>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div class="col-span-12 md:col-span-2 flex items-end">
                        <button id="addProduct" class="w-full bg-purple-600 text-white p-2 rounded-md hover:bg-purple-700 transition-colors">Search</button>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-[#792df3] text-white rounded hover:bg-purple-700">Copy</button>
                    <button class="px-3 py-1 bg-[#792df3] text-white rounded hover:bg-purple-700">Export to CSV</button>
                    <button class="px-3 py-1 bg-[#792df3] text-white rounded hover:bg-purple-700">Export to Excel</button>
                    <button class="px-3 py-1 bg-[#792df3] text-white rounded hover:bg-purple-700">Print</button>

                    <!-- Column Visibility Dropdown -->
                    <div class="dropdown relative">
                        <button class="px-3 py-1 bg-[#792df3] text-white rounded hover:bg-purple-700">
                            Column visibility ▼
                        </button>
                        <div class="dropdown-menu hidden absolute left-0 mt-1 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-50">
                            <div class="p-2 space-y-2">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" checked class="rounded border-gray-300">
                                    <span>Name</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" checked class="rounded border-gray-300">
                                    <span>Status</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" checked class="rounded border-gray-300">
                                    <span>Action</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg" id="productTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-md font-bold">S/L</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Name</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Status</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- Modal (Initially Hidden) -->
    <div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-xl font-semibold">Product Information</h2>
            </div>

            <!-- Modal Body -->
            <form id="supplierForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="space-y-4">
                    <!-- Name -->
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right">
                            Name <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            placeholder="Enter Name"
                            class="col-span-2 w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500"
                            required>
                    </div>

                    <!-- Status -->
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right">
                            Status <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="col-span-2 flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="1" checked class="w-4 h-4 text-purple-600">
                                <span class="ml-2">Active</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="0" class="w-4 h-4 text-purple-600">
                                <span class="ml-2">Inactive</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between mt-8">
                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Save
                    </button>
                    <button type="button" id="closeModalBtn"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Open Modal
            $("#openModalBtn").click(function() {
                $("#myModal").removeClass("hidden");
            });

            // Close Modal
            $("#closeModalBtn, #myModal").click(function(event) {
                // Close only if clicked outside modal content
                if ($(event.target).is("#myModal") || $(event.target).is("#closeModalBtn")) {
                    $("#myModal").addClass("hidden");
                }
            });

            // Close Modal on Escape Key
            $(document).keydown(function(event) {
                if (event.key === "Escape") {
                    $("#myModal").addClass("hidden");
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {

            let table = $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.list') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'action',
                    }
                ]
            });



            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });


            $("#supplierForm").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append("_token", $("input[name='_token']").val());

                $.ajax({
                    url: "{{ route('products.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#myModal").addClass("hidden");
                        $("#supplierForm")[0].reset();
                        Swal.fire({
                            title: "Success!",
                            text: "Product created successfully!",
                            icon: "success",
                            confirmButtonText: "OK"
                        });
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        alert("Something went wrong!");
                    }
                });
            });
        });
    </script>

</x-app-layout>