<x-app-dashboard title="{{ __('Products Management') }}">

    @section('links')
    <!-- DataTables -->
    <link rel="stylesheet" href={{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css") }}>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection
   
    <div class="row d-none">
        <div class="col-12">
            <input type="text" id="countProduct" class="w-100" value="{{ $products->count() }}">
        </div>
    </div>

    <x-slot name="header">
        {{ __('List of Product') }}
    </x-slot>
    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('Products Management') }}</li>
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
                        <button formaction="{{ route('owner.product.deleteAll') }}" class="btn btn-danger float-left" type="submit" hidden id="btn-delet-all" onclick="return confirm('{{ __('Are you sure?') }}')">
                            <i class="fas fa-solid fa-trash"></i> {{ __('Delete All Selected') }}
                        </button>
                        <button type="button" class="btn btn-purple float-right" data-toggle="modal"
                            data-target="#modal-create-user">
                            {{ __('Create New Product') }} <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                    @if($products->count() > 0)
                    <div class="card-body">
                        <table id="table_product" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" class="selectall" style="max-width: 15px !important;"></th>
                                    <th>Judul Produk</th>
                                    <th>Pekerja</th>
                                    <th>Kategori Produk</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Dikerjakan</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td class="text-center" style="width: 15px !important;"><input type="checkbox" name="ids[]" class="selectbox" value="{{ $product->id }}"></td>
                                    <td>
                                        {{ $product->name }}
                                    </td>
                                    <td>
                                        {{ $product->worker->name }}
                                    </td>
                                    <td>
                                        {{ $product->category->name }}
                                    </td>
                                    <td>
                                        {{ $product->quantity }}
                                    </td>
                                    <td>
                                        {{ $product->completed_date }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center text-center">
                                            <a data-toggle="modal" data-target="#modal-edit{{ $product->id }}" class="btn btn-sm btn-warning ml-1 d-inline-flex align-items-center font-small">
                                                {{ __('Edit') }} <i class="fas fa-edit ml-2"></i>
                                            </a>
                                            <form method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button formaction="{{ route('products.destroy', $product->id) }}" class="btn btn-sm btn-danger ml-1 d-inline-flex align-items-center font-small" onclick="return confirm('{{ __('Are you sure?') }}')">
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

    <!--- Modal Creat -->
    <div class="modal fade" id="modal-create-user">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-purple">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> {{ __('New Product Form') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('products.store') }}" id="form_create_product"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="border-bottom text-danger" style="border-color: #6F42C1 !important">
                            {{ __('* required fileds') }}
                        </div>
                        <div class="form-group mb-1">
                            <label for="id_user" class="col-form-label">Pekerja <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_user select2" style="width: 100%;" name="id_user">
                                <option selected="selected" disabled>Pilih Pekerja</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text id_user_error"></span>
                        </div>
                       
                        <div class="form-group mb-1">
                            <label for="id_category" class="col-form-label">Kategori Produk <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_category select2" style="width: 100%;" name="id_category">
                                <option selected="selected" disabled>Pilih Kategori Produk</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text id_category_error"></span>
                        </div>
                        <div class="form-group mb-1 ">
                            <label for="name" class="col-form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control error_input_name" placeholder="Masukan nama produk.." name="name" >
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group mb-1 ">
                            <label for="quantity" class="col-form-label">Jumlah Produk <span class="text-danger">*</span></label>
                            <input type="text" id="quantity" class="form-control error_input_quantity" placeholder="Masukan Jumlah Produk yang diselesaikan.." name="quantity" >
                            <span class="text-danger error-text quantity_error"></span>
                        </div>
                        <div class="form-group mb-1 ">
                            <label for="completed_date" class="col-form-label">Tanggal diselesaikan <span class="text-danger">*</span></label>
                            <input type="date" id="completed_date" class="form-control error_input_completed_date" placeholder="Masukan Jumlah Produk yang diselesaikan.." name="completed_date" >
                            <span class="text-danger error-text completed_date_error"></span>
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

    <!--- Modal Edit -->
    @foreach ($products as $product_edit)
    <div class="modal fade" id="modal-edit{{ $product_edit->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark" style="border-bottom:2px solid #FFC107 !important;">
                    <h3 class="modal-title">
                        <span class="badge badge-warning"><i class="fas fa-edit"></i> 
                            {{ $product_edit->name }}
                        </span>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFC107">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('products.update', $product_edit->id) }}" id="form_edit_product{{ $loop->iteration }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="border-bottom text-danger" style="border-color: #6F42C1 !important">
                            {{ __('* required fileds') }}
                        </div>
                        <div class="form-group mb-1">
                            <label for="id_user" class="col-form-label">Pekerja <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_user select2" style="width: 100%;" name="id_user">
                                <option selected="selected" disabled>Pilih Pekerja</option>
                                @foreach ($users as $user)
                                    @if(old('id_user', $product_edit->worker->id) == $user->id)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="text-danger error-text id_user_error"></span>
                        </div>
                       
                        <div class="form-group mb-1">
                            <label for="id_category" class="col-form-label">Kategori Produk <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_category select2" style="width: 100%;" name="id_category">
                                <option selected="selected" disabled>Pilih Kategori Produk</option>
                                @foreach ($categories as $category)
                                    @if(old('id_user', $product_edit->category->id) == $category->id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="text-danger error-text id_category_error"></span>
                        </div>
                        <div class="form-group mb-1 ">
                            <label for="name" class="col-form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control error_input_name" placeholder="Masukan nama produk.." name="name" value="{{ $product_edit->name }}">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group mb-1 ">
                            <label for="quantity" class="col-form-label">Jumlah Produk <span class="text-danger">*</span></label>
                            <input type="number" min="1" id="quantity" class="form-control error_input_quantity" placeholder="Masukan Jumlah Produk yang diselesaikan.." name="quantity" value="{{ $product_edit->quantity }}"  >
                            <span class="text-danger error-text quantity_error"></span>
                        </div>
                        {{-- <div class="form-group mb-1 ">
                            <label for="completed_date" class="col-form-label">Tanggal diselesaikan <span class="text-danger">*</span></label>
                            {{ $product_edit->completed_date }}
                            <input type="date" id="completed_date" class="form-control error_input_completed_date" placeholder="Masukan Jumlah Produk yang diselesaikan.." name="completed_date" value="{{ $product_edit->completed_date }}"  >
                            <span class="text-danger error-text completed_date_error"></span>
                        </div> --}}
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-dark">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
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
        $("#table_product").DataTable({
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

        $('#form_create_product').on('submit', function (e) {
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
                            $('select.error_input_' + prefix).addClass('is-invalid');
                            $('textarea.error_input_' + prefix).addClass('is-invalid');
                            $(".select2").css("border", "1.5px solid red", "important");
                            $(".select2").css("border-style", "solid double");
                            $(".select2").css("border-radius", "5px");
                        });
                        alertToastInfo(data.msg)
                    } else {
                        $('#form_create_product')[0].reset();
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


        const countProduct = document.querySelector('#countProduct');

        for (let i = 1; i <= countProduct.value; i++) {
            $('#form_edit_product'+i).on('submit', function (e) {
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
                                $('select.error_input_' + prefix).addClass('is-invalid');
                                $('textarea.error_input_' + prefix).addClass('is-invalid');
                                $(".select2").css("border", "1.5px solid red", "important");
                                $(".select2").css("border-style", "solid double");
                                $(".select2").css("border-radius", "5px");
                            });
                            alertToastInfo(data.msg)
                        } else {
                            $('#form_edit_product'+i)[0].reset();
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
        }
    </script>
    @endsection

</x-app-dashboard>
 