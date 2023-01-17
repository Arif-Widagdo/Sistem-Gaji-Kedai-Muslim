<x-app-dashboard title="{{ __('Monthly Salary Recap Report') }}">
    @section('links')
    <!-- DataTables -->
    <link rel="stylesheet" href={{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css") }}>
    @endsection

    <x-slot name="header">
        {{ __('Monthly Salary Recap Report') }}
    </x-slot>

    <!-- Main row -->
    <div class="row animate__animated animate__slideInLeft">
        <div class="col-md-12">
            <div class="card card-purple card-outline">
                <div class="card-body">
                    <table id="month_sallary" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>{{ __('Monthly Salary Recap Report') }}</th>
                                <th class="text-center">{{ __('Total') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sallaries as $key => $salary)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $key }}</td>
                                <td class="text-center">Rp. {{ number_format($salary->sum('total'),2,',','.') }}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center text-center">
                                        <a class="btn btn-sm btn-info ml-1 d-inline-flex align-items-center font-small" href="{{ route('recap.sallary.show', $key) }}">
                                            {{ __('Show') }} <i class="fas fa-eye ml-2"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->


    @section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src={{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}></script>
    <script src={{ asset("plugins/datatables-responsive/js/dataTables.responsive.min.js") }}></script>
    <script src={{ asset("plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}></script>
    <script src={{ asset("plugins/datatables-buttons/js/dataTables.buttons.min.js") }}></script>
    <script src={{ asset("plugins/datatables-buttons/js/buttons.bootstrap4.min.js") }}></script>
    <script src={{ asset("plugins/jszip/jszip.min.js") }}></script>
    <script src={{ asset("plugins/pdfmake/pdfmake.min.js") }}></script>
    <script src={{ asset("plugins/pdfmake/vfs_fonts.js") }}></script>
    <script src={{ asset("plugins/datatables-buttons/js/buttons.html5.min.js") }}></script>
    <script src={{ asset("plugins/datatables-buttons/js/buttons.print.min.js") }}></script>
    <script src={{ asset("plugins/datatables-buttons/js/buttons.colVis.min.js") }}></script>
  
    <!-- Customs for pages -->
    <script>
        // -------- Data Table
        $("#month_sallary").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "lengthMenu": [ [-1, 100, 50, 25, 10, 5], ["{{ __('All') }}", 100, 50, 25, 10, 5] ],
            "order": [],
            "columnDefs": [{
                "targets": [0, 3],
                "orderable": false,
            }],
            "oLanguage": {
                "sSearch": "{{ __('Quick Search') }}",
                "sLengthMenu": "{{ __('DataTableLengthMenu') }}",
                "sInfo": "{{ __('DataTableInfo') }}",
                "oPaginate": {
                    "sPrevious": "{{ __('Previous') }}", // This is the link to the previous page
                    "sNext": "{{ __('Next') }}", // This is the link to the next page
                },
                "sInfoEmpty": "{{ __('DataTableInfoEmpty') }}",
                "sInfoFiltered": "{{ __('DataTabelInfoFiltered') }}"
            },
            "buttons": [{
                        "extend": 'copy',
                        "title": "{{ __('Monthly Salary Recap Report') }}",
                        "exportOptions": {
                            "columns": [0, 1, 2]
                        }
                    },
                    "colvis"
                ]
        }).buttons().container().appendTo('#month_sallary_wrapper .col-md-6:eq(0)');
    </script>
    @endsection
</x-app-dashboard>