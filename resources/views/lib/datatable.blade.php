@once
    @push("js")
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
          $.extend($.fn.dataTable.defaults, {
            'language': {
              'lengthMenu': 'จำนวนที่แสดง _MENU_',
              'info': '_START_ - _END_ จาก _TOTAL_',
              'search': 'ค้นหา : ',
              "loadingRecords": "กำลังเตรียมข้อมูล",
              "processing":     "กำลังเตรียมข้อมูล",
              "zeroRecords":    "ไม่พบข้อมูล",
              'emptyTable': 'ไม่พบข้อมูล',
              'paginate': {
                'first': 'ก่อนหน้า',
                'last': 'หลังสุด',
                'next': '>',
                'previous': '<'
              },
              infoEmpty: 'แสดงทั้งหมด 0 รายการ',
              searchPlaceholder: 'ค้นหา',
            },
          })
        </script>
    @endpush
    @push('css')
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"/>
        <style>
            .dataTable {
                border-radius: 10px;
                border: 1px solid #DEE2E6;
            }
            tr th:first-child {
                border-radius: 10px 0 0 0!important;
            }
            tr th:last-child {
                border-radius: 0 10px 0 0!important;
            }
            th, tr {
                background: #3eb57d;
                padding: 15px!important;
            }
            .sorting {
                color: #ffffff;
                border-bottom: 0!important;
            }

            .dataTables_wrapper .dataTables_info {
                clear: none!important;
            }
            .dataTables_length {
                color: #8492A6!important;
                margin-top: 6px;
            }
            select {
                margin-right: 10px;
                font-size: 16px;
                color: #9DA2A7!important;
                border: 1px solid #EEEEEE!important;
                border-radius: 10px!important;
                option {
                    color: #3eb57d!important;
                }
            }
            .dataTables_info {
                font-size: 14px;
                color: #8492A6!important;
            }
            .paginate_button.previous.disabled {
                color: #ABABAB;
            }
            .paginate_button {
                border: 0!important;
            }
            .dataTables_paginate.paging_simple_numbers {
                color: #3eb57d;
            }
            .paginate_button.current {
                border: 0!important;
                color: #ffffff!important;
                background: #3eb57d!important;
                border-radius: 10px!important;
                padding: 4px 14px !important;
            }

            input[type="search"] {
                border-radius: 12px!important;
                border: 1px solid #BABEC0!important;
            }
            .dataTables_filter {
                margin-bottom: 10px;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
                color: #ffffff !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                border-radius: 12px!important;
                background: #ddd!important;
                color: #3eb57d!important;
            }
        </style>
    @endpush
@endonce
