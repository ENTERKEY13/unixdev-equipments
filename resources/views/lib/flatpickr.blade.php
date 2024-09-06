@once
    @push('js')
        <script type="text/javascript" src="{{asset('assets/framework/flatpickr/flatpickr.min.js')}}"></script>
        @if(isset($monthSelect) && $monthSelect)
            <script type="text/javascript" src="{{asset('assets/framework/flatpickr/monthselect/monthselect.js')}}"></script>
        @endif
    @endpush
    @push('css')
        <link rel="stylesheet" href="{{asset('assets/framework/flatpickr/flatpickr.min.css')}}"/>
        @if(isset($monthSelect) && $monthSelect)
            <link rel="stylesheet" href="{{asset('assets/framework/flatpickr/monthselect/monthselect.css')}}"/>
        @endif
    @endpush
@endonce
