<x-app-dashboard title="{{ __('User Positions Management') }}">
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
        @if(app()->getLocale()=='id')
            {{ __('List of users by') }} {{ __('Position') }} {{ $position->name }}
        @else
            {{ __('List of users by') }} {{ $position->name }} {{ __('Position') }}
        @endif
    </x-slot>
    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="{{ route('positions.index') }}">{{ __('User Positions Management') }}</a></li>
            <li class="breadcrumb-item active">{{ __('User Management') }}</li>
        </ol>
    </x-slot>

    <div class="row d-none">
        <div class="col-12">
            <input type="text" id="countUser" class="w-100" value="{{ $users_position->count() }}">
        </div>
    </div>

    <!-- Main row -->
    <div class="row animate__animated animate__slideInUp">
        <div class="col-md-12">
            <div class="card card-purple card-outline">
                <form method="post" action="{{ route('owner.users.deleteAll') }}" id="form_deleteAll_user">
                    @method('delete')
                    @csrf
                    <div class="card-header">
                        <button class="btn btn-danger float-left" type="submit" hidden id="btn_delete_all">
                            <i class="fas fa-solid fa-trash-alt"></i> {{ __('Delete All Selected') }}
                        </button>
                        <button type="button" class="btn btn-purple float-right" data-toggle="modal"
                            data-target="#modal-create-user">
                            {{ __('Create new user') }} <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                    @if($users_position->count() > 0)
                    <div class="card-body">
                        <table id="table-positions" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" class="selectall" style="max-width: 15px !important; cursor:pointer;"></th>
                                    <th>{{ __('User Names') }}</th>
                                    <th>{{ __('Email Address') }}</th>
                                    <th class="text-center">{{ __('Positions') }}</th>
                                    <th class="text-center">{{ __('Activation Status') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users_position as $user)
                                <tr>
                                    <td class="text-center" style="width: 15px !important;"><input type="checkbox" name="ids[]" class="selectbox" value="{{ $user->id }}" style="cursor:pointer;"></td>
                                    <td class="fw-500">
                                        @if(Str::length($user->name) > 20)
                                            {{ substr( $user->name, 0, 20) }} ...
                                        @else
                                            {{ $user->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td class="text-center">
                                        @if($user->userPosition->name == 'Owner')
                                        <span class="badge badge-success border shadow">{{ $user->userPosition->name }}</span>
                                        @else
                                        <span class="badge badge-light border border-dark">{{ $user->userPosition->name }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($user->status_act == 1)
                                        <i class="fas fa-check-circle text-success text-lg shadow rounded-circle"></i>
                                        @else
                                        <i class="fas fa-times-circle text-danger text-lg shadow rounded-circle"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center text-center">
                                            <a class="btn btn-sm btn-info ml-1 d-inline-flex align-items-center font-small" data-toggle="modal" data-target="#modal-show{{ $user->id }}">
                                                {{ __('Show') }} <i class="fas fa-eye ml-2"></i>
                                            </a>
                                            <a data-toggle="modal" data-target="#modal-edit{{ $user->id }}" class="btn btn-sm btn-warning ml-1 d-inline-flex align-items-center font-small">
                                                {{ __('Edit') }} <i class="fas fa-edit ml-2"></i>
                                            </a>
                                            
                                            <form method="post" class="d-inline" action="{{ route('users.destroy', $user->id) }}" 
                                                id="form_delete_user{{ $loop->iteration }}">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger ml-1 d-inline-flex align-items-center font-small" id="btn_delete{{ $loop->iteration }}">
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
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> {{ __('New User Registration Form') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('users.store') }}" id="form_create_user"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="border-bottom text-danger" style="border-color: #6F42C1 !important">
                            {{ __('* required fileds') }}
                        </div>
                        <div class="form-group mb-1">
                            <label for="name" class="col-form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control error_input_name"
                                placeholder="{{ __('Enter') }} {{ __('Name') }}" name="name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="email" class="col-form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                            <input type="email" id="email" class="form-control error_input_email" placeholder="{{ __('Enter') }} {{ __('Email') }}" name="email">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="id_position" class="col-form-label">{{ __('User Position') }} <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_position select2" style="width: 100%;" name="id_position">
                                <option selected="selected" value="{{ $position->id }}">{{ $position->name }}</option>
                            </select>
                            <span class="text-danger error-text id_position_error"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="gender" class="col-form-label">{{ __('Gender') }} <span class="text-danger">*</span></label>
                            <select class="form-control error_input_gender" style="width: 100%;" name="gender">
                                <option selected="selected" disabled>{{ __('Select Gender') }}</option>
                                <option value="M">{{ __('Male') }}</option>
                                <option value="F">{{ __('Female') }}</option>
                            </select>
                            <span class="text-danger error-text gender_error"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="noHp" class="col-form-label">{{ __('Number Phone') }}</label>
                            <input type="number" id="noHp" class="form-control error_input_telp" placeholder="{{ __('Enter') }} {{ __('Number Phone') }}" name="telp">
                            <span class="text-danger error-text telp_error"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="address" class="col-form-label">{{ __('Address') }}</label>
                            <textarea class="form-control error_input_address" id="address" name="address" cols="50" rows="2" placeholder="{{ __('Enter') }} {{ __('Address') }}"></textarea>
                            <span class="text-danger error-text address_error"></span>
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

     <!---- Modal Show --->
     @foreach ($users_position as $user)
     <div class="modal fade" id="modal-show{{ $user->id }}">
         <div class="modal-dialog modal-lg" >
             <div class="modal-content rounded-3">
                 <div class="modal-body ">
                     <div class="card-body box-profile">
                         <div class="text-center">
                             <a target="_blank" href="{{ $user->picture }}" data-toggle="lightbox" data-title="bumdes" data-gallery="gallery">
                                 <img class="profile-user-img img-fluid img-circle" src="{{ $user->picture }}"
                                     alt="User profile picture">
                             </a>
                         </div>
                         <p class="text-muted text-center mb-0">
                            {{ $user->userPosition->name }}
                         </p>
                         <h3 class="profile-username text-center mt-0 mb-4">
                            {{ $user->name }}
                         </h3>
                         <div class="row">
                             <div class="col-lg-12">
                                 <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item d-flex align-items-center">
                                        <p class="col-lg-4 text-bold">{{ __('Name') }}</p> <p class="col-lg-8">: {{ $user->name }}</p>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <p class="col-lg-4 text-bold">{{ __('User Position') }}</p> <p class="col-lg-8">: {{ $user->userPosition->name }}</p>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <p class="col-lg-4 text-bold">{{ __('Created date') }}</p> <p class="col-lg-8">: {{ $user->created_at }}</p>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <p class="col-lg-4 text-bold">{{ __('Email') }}</p> <p class="col-lg-8">: {{ $user->email }}</p>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <p class="col-lg-4 text-bold">{{ __('Gender') }}</p> 
                                        <p class="col-lg-8">: 
                                             @if($user->gender == 'M')
                                                 {{ __('Male') }}
                                             @else
                                                 {{ __('Female') }}
                                             @endif
                                        </p>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <p class="col-lg-4 text-bold">{{ __('Telp') }}</p> 
                                        <p class="col-lg-8">: {{ $user->telp }}
                                            @if($user->telp != '')
                                            <span>
                                                <a href="https://api.whatsapp.com/send/?phone={{ $user->telp }}&text=Hello {{ $user->name }}&type=phone_number&app_absent=0" 
                                                    target="_blank"
                                                    class="bg-primary pb-2 pt-2 pr-2 pl-1 rounded-pill">
                                                    <i class="fas fa-phone bg-light rounded-circle p-2"></i> {{ __('Call') }} {{ $user->name }} {{ __('Now') }}
                                                </a>
                                            </span>
                                            @endif
                                        </p>
                                    </li>
                                 </ul>
                             </div>
                           
                             <div class="col-lg-12">
                                 <li class="list-group-item d-flex flex-column p-2">
                                     <p class="text-bold">{{ __('Address') }}</p> <p class=""> 
                                         @if($user->address != '')                               
                                         {{ $user->address }}
                                         @endif
                                     </p>
                                 </li>
                             </div>
                         </div>
                        
                     </div>
                     <!-- /.card-body -->
                 </div>
                 <div class="modal-footer float-sm-right">
                     <button type="button" class="btn btn-default " data-dismiss="modal">{{ __('CLose') }}</button>
                 </div>
             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>
     @endforeach
     <!-- /.modal -->

      <!---- Modal Edit admin --->
    @foreach ($users_position->where('id', '!=', Auth::user()->id) as $user)
    <div class="modal fade" id="modal-edit{{ $user->id }}">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-3">
                <div class="modal-header bg-dark" style="border-bottom:2px solid #FFC107 !important;">
                    <h3 class="modal-title"><span class="badge badge-warning"><i class="fas fa-edit"></i> {{ __('User Edit Form') }} </span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFC107">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('users.update', $user->id) }}" 
                    enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="border-bottom border-dark text-danger">
                            {{ __('* required fileds') }}
                        </div>
                        <div class="form-group mb-1">
                            <label for="role" class="col-form-label">{{ __('Change Position As') }} <span class="text-danger">*</span></label>
                            <select class="form-control error_input_id_position select2" style="width: 100%;" name="id_position">
                                <option selected="selected" disabled>{{ __('Select User Position') }}</option>
                                @foreach ($positions as $position)
                                    @if(old('id_position', $user->userPosition->id) == $position->id)
                                        <option value="{{ $position->id }}" selected>{{ $position->name }}</option>
                                    @else
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="text-danger error-text role_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="status_actv" class="col-form-label">{{ __('Change Activation Status') }} <span class="text-danger">*</span></label>
                            <select class="form-control" style="width: 100%;" name="status_act">
                                @if($user->status_act == 1)
                                <option value="1" selected="selected">{{ __('Active') }}</option>
                                <option value="0">{{ __('Blocked') }}</option>
                                @else
                                <option value="0" selected="selected">{{ __('Blocked') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                                @endif
                            </select>
                            <span class="text-danger error-text status_actv_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-dark">{{ __('Save Change') }}</button>
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
        $("#table-positions").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "{{ __('All') }}"]
            ],
            "order": [],
            "columnDefs": [{
                "targets": [0, 5],
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

        $('#form_create_user').on('submit', function (e) {
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
                        });
                        alertToastInfo(data.msg)
                    } else {
                        $('#form_create_user')[0].reset();
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

        const countUser = document.querySelector('#countUser');

        for (let i = 1; i <= countUser.value; i++) {
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
                        document.getElementById('form_delete_user'+i).submit();
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
                    document.getElementById('form_deleteAll_user').submit();
                }
            });
        });


    </script>
    @endsection
</x-app-dashboard>