<x-app-dashboard title="{{ __('Pay List') }}">
    @section('links')
    <!-- DataTables -->
    <link rel="stylesheet" href={{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css") }}>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection


    <x-slot name="header">
        {{ __('Pay List') }}
    </x-slot>

    <div class="row d-none">
        <div class="col-12">
            <input type="text" id="countSallary" class="w-100" value="{{ $sallaries->count() }}">
        </div>
    </div>

    <!-- Main row -->
    <div class="row animate__animated animate__slideInUp">
        <div class="col-md-12">
            <div class="card card-purple card-outline">
                <form method="post">
                    @method('delete')
                    @csrf
                    <div class="card-header">
                        <a class="btn btn-danger float-left" id="btn_delete_all" hidden>
                            <i class="fas fa-solid fa-trash-alt"></i> {{ __('Delete All Selected') }}
                        </a>
                        <button formaction="{{ route('owner.sallary.deleteAll') }}" class="d-none" type="submit" id="form_deleteAll_sallary">
                            {{ __('Delete All Selected') }}
                        </button>
                        <a class="btn btn-purple float-right" href="{{ route('owner.sallary.create') }}">
                            {{ __('Create Sallary') }} <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="table_sallary" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" class="selectall" style="max-width: 15px !important; cursor: pointer;"></th>
                                    <th>{{ __('User Names') }}</th>
                                    <th>{{ __('Periode') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sallaries as $salary)
                                <tr>
                                    <td class="text-center" style="width: 15px !important;"><input type="checkbox" name="ids[]" class="selectbox" value="{{ $salary->id }}" style="cursor: pointer;"></td>
                                    <td>
                                       {{ $salary->userSallary->name }}
                                    </td>
                                    <td>
                                        {{ $salary->periode }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($salary->total,2,',','.') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center text-center">
                                            <a class="btn btn-sm btn-info ml-1 d-inline-flex align-items-center font-small" href="{{ route('owner.sallary.show', $salary->id) }}">
                                                {{ __('Show') }} <i class="fas fa-eye ml-2"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger ml-1 d-inline-flex align-items-center font-small" id="btn_delete{{ $loop->iteration }}">
                                                {{ __('Remove') }} <i class="fas fa-solid fa-trash-alt ml-2"></i>
                                            </a>
                                            <form method="post" class="d-none">
                                                @method('delete')
                                                @csrf
                                                <button formaction="{{ route('owner.sallary.destroy', $salary->id) }}" 
                                                    class="d-none" id="form_delete_sallary{{ $loop->iteration }}">
                                                    {{ __('Remove') }} <i class="fas fa-solid fa-trash-alt ml-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
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
    <!-- SweetAlert 2 | Display Message -->
    <script src="{{ asset('dist/js/sweetalert2.all.min.js') }}"></script>
  
    <!-- Customs for pages -->
    <script>
        // -------- Data Table
        $("#table_sallary").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "{{ __('All') }}"]
            ],
            "order": [],
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false,
            }],
            "oLanguage": {
                "sSearch": "{{ __('Quick Search') }}",
                "sLengthMenu": "{{ __('DataTableLengthMenu') }}",
                "sInfo": "{{ __('DataTableInfo') }}",
                "oPaginate": {
                    // "sFirst": "First page", // This is the link to the first page
                    "sPrevious": "{{ __('Previous') }}", // This is the link to the previous page
                    "sNext": "{{ __('Next') }}", // This is the link to the next page
                    // "sLast": "Last page" // This is the link to the last page
                },
                "sInfoEmpty": "{{ __('DataTableInfoEmpty') }}",
                "sInfoFiltered": "{{ __('DataTabelInfoFiltered') }}"
            },
            "buttons": [{
                        "extend": 'copy',
                        "title": "{{ __('List of Users') }}",
                        "exportOptions": {
                            "columns": [1, 2, 3]
                        }
                    },
                    {
                        "extend": 'excel',
                        "title": "{{ __('List of Users') }}",
                        "exportOptions": {
                            "columns": [1, 2, 3]
                        }
                    },
                    {
                        "extend": 'print',
                        "title": "{{ __('List of Users') }}",
                        "exportOptions": {
                            "columns": [1, 2, 3]
                        }
                    },
                    "colvis"
                ]
        }).buttons().container().appendTo('#table_sallary_wrapper .col-md-6:eq(0)');


        $('.selectall').click(function () {
            $('.selectbox').prop('checked', $(this).prop('checked'));
            $("#btn_delete_all").prop("hidden", !$(this).prop('checked'));
        });

        $('.selectbox').change(function () {
            var total = $('.selectbox').length;
            var number = $('.selectbox:checked').length;
            if (total == number) {
                $('.selectall').prop('checked', true);
            } else {
                $('.selectall').prop('checked', false);
            }
            $("#btn_delete_all").prop("hidden", !$('.selectbox:checked').length);
        });

        const countProduct = document.querySelector('#countSallary');

        for (let i = 1; i <= countProduct.value; i++) {
            $('#btn_delete'+i).on('click',function(e){
                e.preventDefault();
                swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('You wont be able to revert this') }}",
                    icon: 'warning',
                    iconColor: '#FD7E14',
                    showCancelButton: true,
                    confirmButtonColor: '#6F42C1',
                    cancelButtonColor: '#DC3545',
                    confirmButtonText: "{{ __('Yes, deleted it') }}",
                    cancelButtonText: "{{ __('Cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed){
                        $("#form_delete_sallary"+i).click();
                    }
                });
            });
        }

        $('#btn_delete_all').on('click',function(e){
            e.preventDefault();
            swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You wont be able to revert this') }}",
                icon: 'warning',
                iconColor: '#FD7E14',
                showCancelButton: true,
                confirmButtonColor: '#6F42C1',
                cancelButtonColor: '#DC3545',
                confirmButtonText: "{{ __('Yes, deleted it') }}",
                cancelButtonText: "{{ __('Cancel') }}"
            }).then((result) => {
                if (result.isConfirmed){
                    $("#form_deleteAll_sallary").click();
                }
            });
        });

        // $('#form_create_sallary').on('submit', function (e) {
        //     e.preventDefault();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         method: $(this).attr('method'),
        //         data: new FormData(this),
        //         processData: false,
        //         dataType: 'json',
        //         contentType: false,
        //         beforeSend: function () {
        //             $(document).find('span.error-text').text('');
        //         },
        //         success: function (data) {
        //             if (data.status == 0) {
        //                 $.each(data.error, function (prefix, val) {
        //                     console.log(prefix)
        //                     $('span.' + prefix + '_error').text(val[0]);
                            
                               
        //                     //     // $('select.error_input_' + prefix).addClass('is-invalid');
        //                     //     // $(".select2").css("border", "1.5px solid red", "important");
        //                     //     // $(".select2").css("border-style", "solid double");
        //                     //     // $(".select2").css("border-radius", "5px");
        //                 });
                       
        //                 alertToastInfo(data.msg)
        //             } else {
        //                 $('#form_create_product')[0].reset();
        //                 setTimeout(function () {
        //                             location.reload(true);
        //                         }, 1000);
        //                 alertToastSuccess(data.msg)
        //             }
        //         },
        //         error: function (xhr) {
        //             Swal.fire(xhr.statusText, '{{ __('Wait a few minutes to try again ') }}', 'error')
        //         }
        //     });
        // });
      

      

    </script>
    @endsection
</x-app-dashboard>