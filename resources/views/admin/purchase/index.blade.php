<x-app-layout>

    <div class="min-h-screen p-4 md:p-6 lg:p-8">
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
                    <div class="col-span-6 md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                        <select id="supplier_id" name="supplier_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">All Supplier</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" id="start_date" name="start_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date <span class="text-red-500">*</span></label>
                        <input type="date" id="end_date" name="end_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div class="col-span-12 md:col-span-2 flex items-end">
                        <button id="filter_purchases" class="w-full bg-purple-600 text-white p-2 rounded-md hover:bg-purple-700 transition-colors">Search</button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="">
                <table class="overflow-x-auto w-full bg-white border border-gray-200 rounded-lg" id="purchaseTable">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-md font-bold">Order No</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Date</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Supplier</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Total</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Paid</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Due</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Status</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Notes</th>
                            <th class="px-6 py-3 text-left text-md font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="px-6 py-3 font-bold">Total</th>
                            <th class="px-6 py-3 text-left text-md font-bold">0</th>
                            <th class="px-6 py-3 text-left text-md font-bold">0</th>
                            <th class="px-6 py-3 text-left text-md font-bold">0</th>
                            <th colspan="3" class="px-6 py-3 text-left text-md font-bold"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>


    <script>
        $(document).ready(function() {

            let table = $('#purchaseTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('purchase.list') }}",
                    type: "GET",
                    data: function(d) {
                        d.supplier_id = $('#supplier_id').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },

                columns: [{
                        data: "id",
                        title: "Order No",
                        className: "border border-gray-200"
                    },
                    {
                        data: "date",
                        title: "Date",
                        className: "border border-gray-200"
                    },
                    {
                        data: "supplier",
                        title: "Supplier",
                        className: "border border-gray-200"
                    },
                    {
                        data: "total",
                        title: "Total",
                        className: "border border-gray-200"
                    },
                    {
                        data: "paid",
                        title: "Paid",
                        className: "border border-gray-200"
                    },
                    {
                        data: "total",
                        title: "Due",
                        className: "border border-gray-200"
                    },
                    {
                        data: "status",
                        title: "Status",
                        className: "border border-gray-200"
                    },
                    {
                        data: "notes",
                        title: "Notes",
                        className: "border border-gray-200"
                    },
                    {
                        data: "action",
                        title: "Action",
                        className: "border border-gray-200"
                    }
                ],
                lengthMenu: [10, 20, 50, 100],
                pageLength: 10,
                dom: 'lBfrtip',
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
                    },
                ],
                language: {
                    paginate: {
                        first: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">First</span>',
                        previous: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Previous</span>',
                        next: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Next</span>',
                        last: '<span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Last</span>'
                    }
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i :
                            0;
                    };

                    var totalTotal = api.column(3, {
                        page: 'current'
                    }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalPaid = api.column(4, {
                        page: 'current'
                    }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalDue = totalTotal - totalPaid;

                    $(api.column(3).footer()).html(totalTotal.toFixed(2)); // Total
                    $(api.column(4).footer()).html(totalPaid.toFixed(2)); // Paid
                    $(api.column(5).footer()).html(totalDue.toFixed(2)); // Due
                }
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

            $('#filter_purchases').on('click', function() {
                table.ajax.reload();
            });
        });
    </script>

</x-app-layout>