@extends('layouts.app')
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

    <script type="text/x-template" id="selector">
        <div class="select-box position-relative" :class="{open:showSearch}">
            <div @mousedown="openSearch" class="select-box-value project-name-display" :style="{backgroundColor:color,borderColor:color}" v-html="modelValue?modelValue.name:''"></div>
            <div class="search-box-anchor" v-if="showSearch" @mousedown="searchBoxClick">
                <div class="search-box">
                    <div class=" p-1">
                        <input type="text" v-model="searchString" ref="searchInput" class="search-input" @input="onSearchInput"/>
                    </div>
                    <div class="select-option-list">
                        <div v-if="searching">
                            @{{ searchString.length==0?'พิมพ์เพื่อค้นหา':'กำลังค้นหา...' }}
                        </div>
                        <div v-else-if="filteredProjects.length==0">
                            ไม่พบข้อมูล
                        </div>
                        <div v-else class="select-option-item project-name-display" v-for="p in filteredProjects" @mousedown="select(p)" v-html="p.name"></div>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const app = Vue.createApp({
                data() {
                    return {
                        equipment_type_id: '{{ isset($equipment) ? $equipment->equipment_type_id : '' }}',
                        name: '{{ isset($equipment) ? $equipment->name : '' }}',
                        price: '{{ isset($equipment) ? $equipment->price : '' }}',
                        amount: '{{ isset($equipment) ? $equipment->amount : '' }}',
                        errors: {},
                    }
                },
                mounted() {
                    this.initializeSelect();
                },
                methods: {
                    initializeSelect() {
                        $(this.$refs.equipment_type_select).select2({
                            ajax: {
                                url: "{{ route('user.unix.search_equipments') }}",
                                dataType: 'json',
                                delay: 250,
                                data: (params) => ({
                                    s: params.term
                                }),
                                processResults: (data) => ({
                                    results: data.equipments.map(item => ({
                                        id: item.id,
                                        th_name: item.th_name,
                                        en_name: item.en_name
                                    }))
                                }),
                                cache: true
                            },
                            minimumInputLength: 1,
                            placeholder: 'เลือกประเภทอุปกรณ์',
                            allowClear: true,
                            dropdownCssClass: 'custom-dropdown',
                            templateResult: (data) => {
                                if (data.id) {
                                    return $('<div>').html(`${data.th_name} : ${data.en_name}`);
                                }
                                return $('<div>').text(data.th_name || '');
                            },
                            templateSelection: (data) => {
                                if (!data.id) {
                                    return data.th_name || '';
                                }
                                return $('<div>', {
                                    style: 'font-size:1rem; font-weight:normal;',
                                    class: 'me-2 text-start col-lg-auto'
                                }).html(`${data.th_name} : ${data.en_name}`);
                            }
                        }).on('change', (event) => {
                            this.equipment_type_id = $(event.target).val();
                        });
                    },
                    submit() {
                        let url = '{{ isset($equipment) ? route('user.unix.equipment_list_update', $equipment->id) : route('user.unix.equipment') }}';
                        let method = '{{ isset($equipment) ? 'PUT' : 'POST' }}';

                        swalLoading('กำลังบันทึก');

                        $.ajax({
                            url: url,
                            method: method,
                            data: {
                                _token: '{{ csrf_token() }}',
                                equipment_type_id: this.equipment_type_id,
                                name: this.name,
                                price: this.price,
                                amount: this.amount
                            },
                            success: (res) => {
                                if (res.status === 'success') {
                                    swalSuccess('บันทึกสำเร็จ').then(() => {
                                        window.location.href = "{{ route('user.unix.equipment_list') }}";
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
                        {{ isset($equipment) ? 'แก้ไขรายการความต้องการใช้งานอุปกรณ์ออฟฟิศ' : 'ระบบสำรวจความต้องการใช้งานอุปกรณ์ออฟฟิศของพนักงาน' }}
                    </span>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="p-3">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column gap-2">
                            <div>ประเภทอุปกรณ์</div>
                            <select style="width: 100%;" ref="equipment_type_select" v-model="equipment_type_id"></select>
                            <div v-for="error in errors.equipment_type_id ?? []" class="alert alert-danger p-2 mt-2">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <div>ชื่อยี่ห้อ/รุ่น</div>
                            <input class="form-control" type="text" placeholder="name" v-model="name">
                            <div v-for="error in errors.name ?? []" class="alert alert-danger p-2 mt-2">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <div>ราคา</div>
                            <input class="form-control" type="number" placeholder="price" v-model="price">
                            <div v-for="error in errors.price ?? []" class="alert alert-danger p-2 mt-2">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2" v-if="equipment_type_id === '3'">
                            <div>จำนวน</div>
                            <input class="form-control" type="number" placeholder="จำนวน" v-model="amount">
                            <div v-for="error in errors.amount ?? []" class="alert alert-danger p-2 mt-2">
                                @{{ error }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="d-flex gap-3">
                    <a class="btn btn-danger w-100"
                        href="{{url(route('user.unix.equipment_list'))}}">
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
