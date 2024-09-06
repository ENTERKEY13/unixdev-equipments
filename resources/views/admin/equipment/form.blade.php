@extends('layouts.app')
{{--@include('lib.vue')--}}
@push('css')
@endpush

@push('js')
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
{{--    <script src="{{ mix('js/app.js') }}" defer></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>--}}
    <script>
            const app = Vue.createApp({
                data() {
                    return {
                        th_name: '',
                        en_name: '',
                        errors: []
                    }
                },
                methods: {
                    submit() {
                        console.log('submit log');
                        Swal.fire({
                            title: 'Saving',
                            text: 'Please wait...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.post('{{ route('admin.unix.equipment') }}', {
                            _token: '{{ csrf_token() }}',
                            th_name: this.th_name,
                            en_name: this.en_name,
                        })
                            .done(res => {
                                console.log(res);
                                if (res.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: res.message
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire('Error', res.message, 'error');
                                }
                            })
                            .fail((res) => {
                                Swal.fire('Error', 'An error occurred while saving data.', 'error');
                            });
                    },
                }
            });

            app.mount('#equipment');
    </script>
@endpush

@section('content')
    <div id="equipment" class="container mt-5" style="max-width: 750px;">
        <div class="card">
            <div class="card-header">
                <div class="text-center">
                    <span class="fs-4">เพิ่มประเภทอุปกรณ์ของออฟฟิศ</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <div class="d-flex flex-column gap-3 mt-2">
                    <div class="d-flex flex-column gap-2">
                        <div>ประเภทอุปกรณ์ (ภาษาไทย)</div>
                        <input class="form-control" type="text" v-model="th_name" placeholder="ประเภทอุปกรณ์">
                    </div>
                    <div class="d-flex flex-column gap-2 mt-2 mb-2">
                        <div>ประเภทอุปกรณ์ (ภาษาอังกฤษ)</div>
                        <input class="form-control" type="text" v-model="en_name" placeholder="Equipment Type">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn btn-primary w-100" @click="submit">บันทึก</div>
            </div>
        </div>
    </div>
@endsection
