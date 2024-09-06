@once
    @push('css')
        <style>
            .swal2-icon-success .swal2-styled.swal2-confirm,
            .swal2-icon-error .swal2-styled.swal2-confirm {
                background-color: #28a745 !important;
            }
            .swal2-styled:focus {
                box-shadow: none !important;
            }
        </style>
    @endpush
    @push('js')
        <script src="{{url('assets/js/sweetalert2@9.js')}}"></script>
        <script src="{{url("assets/js/sweetalert.js")}}"></script>
    @endpush
@endonce
