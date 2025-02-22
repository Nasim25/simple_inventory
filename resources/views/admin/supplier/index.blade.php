<x-app-layout>
    <div class="min-h-screen p-4 md:p-6 lg:p-8 pb-10">
        <h1 class="text-2xl font-semibold mb-6">Supplier</h1>

        <div class="bg-white p-5 rounded-lg shadow overflow-hidden">

            <div class="flex flex-wrap justify-between items-center mb-4">
                <button id="openModalBtn" class="bg-[#792df3] text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors flex items-center">
                    Create Supplier
                    <span class="ml-1">+</span>
                </button>
            </div>
            <hr class="p-5" />

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="bg-white border border-gray-200 rounded-lg" id="supplierTable">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-md font-bold">S/L</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Name</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Mobile No.</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Email</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Address</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Status</th>
                            <th class="w-20 px-6 py-3 text-left text-md font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
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

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right">
                            Name <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="w-full col-span-2">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Enter Name"
                                class=" w-full px-3 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500"
                                required>
                        </div>

                    </div>


                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right">
                            Mobile No. <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="w-full col-span-2">
                            <input
                                type="tel"
                                placeholder="Enter Mobile No."
                                name="phone"
                                id="phone"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500"
                                required>
                        </div>

                    </div>


                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right">Email</label>
                        <div class="w-full col-span-2">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="Enter Email"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500">
                        </div>

                    </div>


                    <div class="grid grid-cols-3 items-start gap-4">
                        <label class="text-right pt-2">Address</label>
                        <div class="w-full col-span-2">
                            <textarea
                                name="address"
                                id="address"
                                placeholder="Enter address"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500 h-24"></textarea>
                        </div>

                    </div>


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

    <script>
        $(document).ready(function() {

            $("#openModalBtn").click(function() {
                resetFormErrors();
                $("#supplierForm")[0].reset();
                $("#supplierForm").removeAttr("data-id");
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

            let table = $('#supplierTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('suppliers.list') }}",
                columns: [{
                        data: 'id',
                        className: " border border-gray-200"
                    },
                    {
                        data: 'name',
                        className: "border border-gray-200"
                    },
                    {
                        data: 'phone',
                        className: "border border-gray-200"
                    },
                    {
                        data: 'email',
                        className: " border border-gray-200",
                        className: " border border-gray-200"
                    },
                    {
                        data: 'address',
                        className: " border border-gray-200"
                    },
                    {
                        data: 'status',
                        className: " border border-gray-200"
                    },
                    {
                        data: 'action',
                        className: " border border-gray-200"
                    }
                ],
                lengthMenu: [10, 20, 50, 100],
                pageLength: 10,
                dom: 'lBfrtip', // Enables buttons
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fa-solid fa-copy"></i> Copy',
                        className: "table-button-design"
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa-solid fa-file-csv"></i> Export to CSV',
                        className: "custom-button",
                        className: "table-button-design"
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa-solid fa-file-excel"></i> Export to Excel',
                        className: "table-button-design"
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print',
                        className: "table-button-design"
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa-solid fa-eye"></i> Column Visibility',
                        className: "table-button-design"
                    }
                ],
                language: {
                    paginate: {
                        first: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">First</span>',
                        previous: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Previous</span>',
                        next: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Next</span>',
                        last: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Last</span>'
                    }
                }
            });

            function resetFormErrors() {
                $(".error").remove(); // Remove error messages
                $("input, textarea").removeClass("border-red-500"); // Reset input styles
            }
            // Open Edit Modal and Populate Data
            $(document).on("click", ".editSupplier", function() {
                resetFormErrors();
                let supplierId = $(this).data("id");

                $.ajax({
                    url: `/supplier/edit/${supplierId}`,
                    type: "GET",
                    success: function(response) {

                        $("#supplierForm input[name='name']").val(response.supplier.name);
                        $("#supplierForm input[name='phone']").val(response.supplier.phone);
                        $("#supplierForm input[name='email']").val(response.supplier.email);
                        $("#supplierForm textarea[name='address']").val(response.supplier.address);
                        $("input[name='status'][value='" + response.supplier.status + "']").prop("checked", true);
                        $("#supplierForm").attr("data-id", supplierId); // Set form data-id attribute
                        $("#myModal").removeClass("hidden");
                    },
                    error: function() {
                        alert("Failed to fetch supplier data.");
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });


            $("#supplierForm").submit(function(e) {
                e.preventDefault();

                let supplierId = $(this).attr("data-id") || null;
                let formData = new FormData(this);

                if (supplierId) {
                    formData.append("_method", "PUT");
                }

                let url = supplierId ? `/supplier/update/${supplierId}` : "{{ route('suppliers.store') }}";
                let method = "POST";

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#myModal").addClass("hidden");
                        $("#supplierForm")[0].reset();
                        Swal.fire({
                            title: "Success!",
                            text: supplierId ? "Supplier updated successfully!" : "Supplier created successfully!",
                            icon: "success",
                            confirmButtonText: "OK"
                        });
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            resetFormErrors();
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(field, messages) {
                                let inputField = $(`[name="${field}"]`);

                                inputField.addClass("border-red-500");

                                inputField.after(`<span class=" text-sm text-red-600 error ">${messages[0]}</span>`);
                            });
                        } else {
                            Swal.fire({
                                title: "Errod!",
                                text: "Soemthing went wrong!",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            });

            // supplier delete method
            $(document).on("click", ".deleteSupplierBtn", function() {
                let supplierId = $(this).data("id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/supplier/delete/${supplierId}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}" // Add CSRF token if needed
                            },
                            success: function(response) {
                                Swal.fire("Deleted!", "Supplier has been deleted.", "success");
                                table.ajax.reload(null, false); // Reload table without refresh
                            },
                            error: function(xhr) {
                                Swal.fire("Error!", "Something went wrong!", "error");
                            }
                        });
                    }
                });
            });

        });
    </script>

</x-app-layout>