@extends('layouts.app')
@include('lib.sweetalert')
@include('lib.vue')
@include('lib.datatable')
@push('css')

@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#equipment-list').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 450,
                dom: '<"top"f>rt<"bottom"lp><"bottom"i><"clear">',
                ajax: {
                    url: "{{ route('admin.unix.user_equipment_data') }}",
                    type: 'GET', // Ensure the correct method (GET or POST) is used
                    data: function(d) {
                        d._token = '{{ csrf_token() }}'; // Pass the CSRF token here
                    },
                    error: function(xhr, error, thrown) {
                        console.log('Error:', thrown); // Debug any errors
                    }
                },
                order: [
                    [0, 'desc'] // Order by the first column (created_at) in descending order
                ],
                columns: [
                    {
                        data: "created_at",
                        className: 'text-center',
                        render: function(data) {
                            const date = new Date(data);
                            const options = {
                                day: 'numeric',
                                month: 'numeric',
                                year: 'numeric'
                            };
                            return date.toLocaleDateString('en-US', options);
                        }
                    },
                    { data: 'user_name', name: 'user_name', className: 'text-center' },
                    { data: 'equipment_name', name: 'equipment_name', className: 'text-center' },
                    { data: 'name', name: 'name', className: 'text-center' },
                    { data: 'amount', name: 'amount', className: 'text-center' },
                    { data: 'price', name: 'price', className: 'text-center' },
                    { data: 'allAmount', name: 'allAmount', className: 'text-center' }
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    // Calculate the total of the allAmount column
                    var total = api.column(6).data().reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    // Update the footer with the calculated total
                    $(api.column(6).footer()).html(total.toFixed(2));
                }
            });
        });
    </script>
@endpush

@section('content')
    <div id="list_announcement" class="container mt-5" style="max-width: 750px;">
        <div class="card">
            <div class="card-header">
                <div class="text-center">
                    <span class="fs-4">รายการความต้องการใช้งานอุปกรณ์ออฟฟิศของพนักงาน</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive ">
                    <table id="equipment-list" class="table w-100">
                        <thead>
                            <tr>
                                <th class="text-center">วันที่ยื่นคำขอ</th>
                                <th class="text-center">ชื่อพนักงาน</th>
                                <th class="text-center">ประเภท</th>
                                <th class="text-center">รายการ</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">ราคา</th>
                                <th class="text-center">รวม</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <span class="fs-4">รวมราคาของรายการทั้งหมด</span>
                <span class="fs-4">{{number_format($calculate_all_amount, 2)}} บาท</span>
            </div>
        </div>
    </div>
@endsection
