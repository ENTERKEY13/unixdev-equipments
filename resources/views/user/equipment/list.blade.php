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
                    url: '{{ route("user.unix.equipment_destroy", ["id" => ":id"]) }}'.replace(':id', id),
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
    </script>
@endpush

@section('content')
    <div id="list_announcement" class="container mt-5" style="max-width: 750px;">
        <div class="card">
            <div class="card-header">
                <div class="text-center">
                    <span class="fs-4">รายการความต้องการใช้งานอุปกรณ์ออฟฟิศของคุณ</span>
                </div>
            </div>
            <div class="card-body d-flex flex-column gap-4 p-4">
                @foreach($items as $item)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div>{{ $loop->iteration }}. {{ $item->equipment_th_name }} : {{ $item->equipment_en_name }}</div>
{{--                            <div class="text-end">{{ $item->created_at->format('d/m/Y H:i') }}</div>--}}
                            <div class="d-flex gap-3">
                                <a onclick="onDelete({{$item->id}})" class="text-end">
                                    <i class="fas fa-trash" style="color: grey;"></i>
                                </a>
                                <a href="{{ route('user.unix.equipment_list_edit', ['id' => $item->id]) }}" class="text-end">
                                    <i class="fas fa-edit" style="color: grey;"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between p-3">
                            <div>{{ $item->name }}</div>
                            <div>จำนวน {{ $item->amount }} รายการ</div>
                            <div>{{ number_format($item->price, 2) }} บาท</div>
                        </div>
                        <div class="card-footer text-end">
                            <div style="font-weight: bold;">รวม {{ number_format($item->amount * $item->price, 2) }} บาท</div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="card-footer text-end">
                <h5 class="mt-2">ยอดรวมสุทธิ : {{ number_format($calculate_all_amount, 2) }} บาท</h5>
            </div>
        </div>
    </div>
@endsection
