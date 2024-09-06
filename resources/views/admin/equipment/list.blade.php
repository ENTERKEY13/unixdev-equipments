@extends('layouts.app')
@include('lib.sweetalert')
@include('lib.vue')
@include('lib.datatable')
@push('css')

@endpush
@push('js')
    <script>
        function onDelete(id) {
            swalConfirmDelete('ต้องการลบข้อมูล', function() {
                $.ajax({
                    url: '{{ route("admin.unix.equipment_destroy", ["id" => ":id"]) }}'.replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(res) {
                        if (res.success) {
                            swalSuccess('ลบสำเร็จ').then(() => {
                                window.location.reload();
                            });
                        } else {
                            swalError(res.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        swalError('เกิดข้อผิดพลาดในการลบ');
                    }
                });
            });
            return false;
        }

        $(document).ready(function() {
            var table = $('#equipment-list').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 450,
                dom: '<"top"f>rt<"bottom"lp><"bottom"i><"clear">',
                ajax: {
                    url: "{{ route('admin.unix.equipment_data') }}",
                    type: 'GET',
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                    },
                    error: function(xhr, error, thrown) {
                        console.log('Error:', thrown);
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [
                    {
                        data: 'created_at',
                        className: 'text-center',
                        render: function(data) {
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
                    {
                        data: 'id',
                        name: 'id',
                        searchable: false,
                        render: function (id) {
                            return '<div class="nowrap d-flex justify-content-center align-items-center gap-2">'
                                + '<a class="btn btn-info btn-sm" href="' + '{{ route("admin.unix.equipment_list_edit", ["id" => ":id"]) }}'.replace(':id', id) + '">แก้ไข</a>'
                                + ' <a href="javascript:;" class="btn btn-sm btn-danger" onclick="return onDelete(' + id + ')">ลบ</a>'
                                + '</div>'
                        },
                    },
                ],
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
                            <th class="col-auto" style="width: 100px;"></th>
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
