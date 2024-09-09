@extends('layouts.admin.app')
@include('lib.vue')
@include('lib.sweetalert')
@push('css')
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const app = Vue.createApp({
                data() {
                    return {
                        th_name: '{{ isset($equipment) ? $equipment->th_name : '' }}',
                        en_name: '{{ isset($equipment) ? $equipment->en_name : '' }}',
                        errors: {},
                    }
                },
                methods: {
                    submit() {
                        let url = '{{ isset($equipment) ? route('admin.equipment_list_update', $equipment->id) : route('admin.equipment') }}';
                        let method = '{{ isset($equipment) ? 'PUT' : 'POST' }}';

                        swalLoading('กำลังบันทึก');

                        $.ajax({
                            url: url,
                            method: method,
                            data: {
                                _token: '{{ csrf_token() }}',
                                th_name: this.th_name,
                                en_name: this.en_name,
                            },
                            success: (res) => {
                                if (res.status === 'success') {
                                    swalSuccess('บันทึกสำเร็จ').then(() => {
                                        window.location.href = "{{ route('admin.equipment_list') }}";
                                    });
                                } else {
                                    this.errors = res.responseJSON.errors || {};
                                    swalError('กรุณากรอกข้อมูลให้ครบถ้วน');
                                }
                            },
                            error: (res) => {
                                this.errors = res.responseJSON.errors || {};
                                swalError('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');
                            }
                        });
                    }
                }
            });
            app.mount('#equipment');
        });
    </script>

@endpush
@section('content')
    <div id="equipment" class="container mt-5" style="max-width: 750px;">
        <div class="card">
            <div class="card-header">
                <div class="text-center">
                    <span class="fs-4">
                        {{ isset($equipment) ? 'แก้ไขประเภทอุปกรณ์ของออฟฟิศ' : 'เพิ่มประเภทอุปกรณ์ของออฟฟิศ' }}
                    </span>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="p-3">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column gap-2">
                            <div>ประเภทอุปกรณ์ (ภาษาไทย)</div>
                            <input class="form-control" type="text" placeholder="name" v-model="th_name">
                            <div v-for="error in errors.th_name ?? []" class="alert alert-danger p-2 mt-2">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <div>ประเภทอุปกรณ์ (ภาษาอังกฤษ)</div>
                            <input class="form-control" type="text" placeholder="name" v-model="en_name">
                            <div v-for="error in errors.en_name ?? []" class="alert alert-danger p-2 mt-2">
                                @{{ error }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="d-flex gap-3">
                    <a class="btn btn-danger w-100"
                       href="{{url(route('admin.equipment_list'))}}">
                        ยกเลิก
                    </a>
                    @if(isset($equipment))
                        <div class="btn btn-success w-100" @click="submit">บันทึก</div>
                    @else
                        <div class="btn btn-primary w-100" @click="submit">เพิ่ม</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
