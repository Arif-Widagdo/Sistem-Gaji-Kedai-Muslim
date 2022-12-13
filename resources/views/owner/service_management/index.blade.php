<x-app-dashboard title="{{ __('Sallaries Management') }}">

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
        {{ __('List of Sallary by Product and Position') }}
    </x-slot>
    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('Sallaries Management') }}</li>
        </ol>
    </x-slot>

    <!-- Main row -->
    <div class="row animate__animated animate__slideInUp">
        <div class="col-md-12">
            <div class="card card-purple card-outline">
                <form method="post">
                    @method('delete')
                    @csrf
                    <div class="card-header">
                        <button formaction="" class="btn btn-danger float-left" type="submit" hidden id="btn-delet-all" onclick="return confirm('{{ __('Are you sure?') }}')">
                            <i class="fas fa-solid fa-trash"></i> {{ __('Delete All Selected') }}
                        </button>
                        <button type="button" class="btn btn-purple float-right" data-toggle="modal"
                            data-target="#modal-create-user">
                            {{ __('Create new sallary') }} <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                    @if($services->count() > 0)
                    <div class="card-body">
                        <table id="table-service" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" class="selectall" style="max-width: 15px !important;"></th>
                                    <th class="text-center">{{ __('Positions') }}</th>
                                    <th class="text-center">{{ __('Categories') }}</th>
                                    <th>{{ __('Sallary') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td class="text-center" style="width: 15px !important;"><input type="checkbox" name="ids[]" class="selectbox" value="{{ $service->id }}"></td>
                                    <td>
                                        {{ $service->position->name }}
                                    </td>
                                    <td>
                                        {{ $service->category->name }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($service->sallary,2,',','.') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center text-center">
                                            {{-- <a data-toggle="modal" data-target="#modal-edit{{ $service->id }}" class="btn btn-sm btn-warning ml-1 d-inline-flex align-items-center font-small">
                                                {{ __('Edit') }} <i class="fas fa-edit ml-2"></i>
                                            </a> --}}
                                            <form method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button formaction="{{ route('services.destroy', $service->id) }}" class="btn btn-sm btn-danger ml-1 d-inline-flex align-items-center font-small" onclick="return confirm('{{ __('Are you sure?') }}')">
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
                    @else
                    @endif
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <!--- Modal -->
    <div class="modal fade" id="modal-create-user">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-purple">
                    <h5 class="modal-title"><i class="fas fa-coins"></i> {{ __('New Sallary Form') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('services.store') }}" id="form_create_service"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="border-bottom text-danger" style="border-color: #6F42C1 !important">
                            {{ __('* required fileds') }}
                        </div>
                        <div class="form-group mb-1">
                            <label for="id_position" class="col-form-label">{{ __('Position') }} <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_position select2" style="width: 100%;" name="id_position">
                                <option selected="selected" disabled>{{ __('Select User Position') }}</option>
                                @foreach ($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text id_position_error"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="id_category" class="col-form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_category select2" style="width: 100%;" name="id_category">
                                <option selected="selected" disabled>{{ __('Select User Position') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text id_category_error"></span>
                        </div>
                        <div class="form-group row">
                            <label for="sallary" class="col-sm-3 col-form-label">{{ __('Sallary') }} <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp. </span>
                                    </div>
                                    <input class="form-control square error_input_sallary" name="sallary" type="number" min="0" placeholder="{{ __('Enter') }} {{ __('Sallary') }}" value="{{ Auth::user()->telp }}">
                                </div>
                                <span class="text-danger error-text sallary_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
    <!-- Toaster -->
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    <!--- Select 2 --->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- Customs for pages -->
    <script>
        // -------- Data Table
        $("#table-service").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "{{ __('All') }}"]
            ],
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
                    // "sFirst": "First page", // This is the link to the first page
                    "sPrevious": "{{ __('Previous') }}", // This is the link to the previous page
                    "sNext": "{{ __('Next') }}", // This is the link to the next page
                    // "sLast": "Last page" // This is the link to the last page
                },
                "sInfoEmpty": "{{ __('DataTableInfoEmpty') }}",
                "sInfoFiltered": "{{ __('DataTabelInfoFiltered') }}"
            },
        });

        //Initialize Select2 Elements
        $('.select2').select2()

        $('.selectall').click(function () {
            $('.selectbox').prop('checked', $(this).prop('checked'));
            $("#btn-delet-all").prop("hidden", !$(this).prop('checked'));
        });

        $('.selectbox').change(function () {
            var total = $('.selectbox').length;
            var number = $('.selectbox:checked').length;
            if (total == number) {
                $('.selectall').prop('checked', true);
            } else {
                $('.selectall').prop('checked', false);
            }
            $("#btn-delet-all").prop("hidden", !$('.selectbox:checked').length);
        });

        $('#form_create_service').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (data) {
                    if (data.status == 0) {
                        $.each(data.error, function (prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                            $('input.error_input_' + prefix).addClass('is-invalid');
                            $(".select2").css("border", "1.5px solid red", "important");
                            $(".select2").css("border-style", "solid double");
                            $(".select2").css("border-radius", "5px");
                        });
                        alertToastInfo(data.msg)
                    }  else if (data.status == 'exists') {
                        alertToastError(data.msg)
                    } else {
                        $('#form_create_service')[0].reset();
                        setTimeout(function () {
                            location.reload(true);
                        }, 1000);
                        alertToastSuccess(data.msg)
                    }
                },
                error: function (xhr) {
                    Swal.fire(xhr.statusText, '{{ __('Wait a few minutes to try again ') }}', 'error')
                }
            });
        });
    </script>
    @endsection

</x-app-dashboard>
 