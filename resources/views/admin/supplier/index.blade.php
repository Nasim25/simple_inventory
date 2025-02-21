<x-app-layout>

    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dataTables_length select {
            width: 60px;
        }
    </style>

    <div class="max-w-7xl mx-auto mt-10 ">
        <h1 class="text-2xl font-semibold mb-6">Supplier</h1>

        <div class="bg-white p-5 rounded-lg shadow overflow-hidden">
            <!-- Top Controls -->
            <div class="flex flex-wrap justify-between items-center mb-4">
                <button id="openModalBtn" class="bg-[#792df3] text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors flex items-center">
                    Create Supplier
                    <span class="ml-1">+</span>
                </button>
            </div>
            <hr class="p-5" />

            <!-- Table Controls -->
            <div class="flex flex-wrap gap-4 mb-4 items-center">

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
                                    <span>Mobile No</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" checked class="rounded border-gray-300">
                                    <span>Email</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" checked class="rounded border-gray-300">
                                    <span>Address</span>
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
                <table class="w-full bg-white border border-gray-200 rounded-lg" id="supplierTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-md font-bold">S/L</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Name</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Mobile No.</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Email</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Address</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Status</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <!-- <div class="flex items-center justify-between mt-4">
                <div class="text-sm text-gray-700">
                    Showing 1 to 10 of 50 entries
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border rounded hover:bg-gray-50">Previous</button>
                    <button class="px-3 py-1 bg-purple-600 text-white rounded">1</button>
                    <button class="px-3 py-1 border rounded hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border rounded hover:bg-gray-50">3</button>
                    <button class="px-3 py-1 border rounded hover:bg-gray-50">Next</button>
                </div>
            </div> -->
        </div>
    </div>


    <!-- Modal (Initially Hidden) -->
    <div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-xl font-semibold">Supplier Information</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">&times;</button>
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

                    <!-- Mobile -->
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right">
                            Mobile No. <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input
                            type="tel"
                            placeholder="Enter Mobile No."
                            name="phone"
                            id="phone"
                            class="col-span-2 w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500"
                            required>
                    </div>

                    <!-- Email -->
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Enter Email"
                            class="col-span-2 w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500">
                    </div>

                    <!-- Address -->
                    <div class="grid grid-cols-3 items-start gap-4">
                        <label class="text-right pt-2">Address</label>
                        <textarea
                            name="address"
                            id="address"
                            placeholder="Enter address"
                            class="col-span-2 w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500 h-24"></textarea>
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

            let table = $('#supplierTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('suppliers.list') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'address'
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
                    url: "{{ route('suppliers.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#myModal").addClass("hidden");
                        $("#supplierForm")[0].reset();
                        Swal.fire({
                            title: "Success!",
                            text: "Supplier created successfully!",
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