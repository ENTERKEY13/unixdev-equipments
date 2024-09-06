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
                    url: "{{ route('admin.unix.equipment_data') }}",
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
                        data: "created_at ?? '-'",
                        className: 'text-center',
                        render: function(data)
                        {
                            if (!data) {
                                return '-';
                            }
                            const date = new Date(data);
                            const options = {
                                day: 'numeric',
                                month: 'numeric',
                                year: 'numeric'
                            };
                            return date.toLocaleDateString('en-US', options);
                        }
                    },
                    { data: 'th_name', name: 'th_name', className: 'text-center' },
                    { data: 'en_name', name: 'en_name', className: 'text-center' },
                ]
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
                            <th class="text-center">วันที่เพิ่ม</th>
                            <th class="text-center">ประเภท</th>
                            <th class="text-center">Types</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
