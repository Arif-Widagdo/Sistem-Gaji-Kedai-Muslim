<x-app-dashboard title="{{ __('Profile') }}">
    @section('links')
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Ijabo Crop Tool -->
    <link rel="stylesheet" href="{{ asset('plugins/ijabo-crop-tool/ijaboCropTool.min.css') }}">
    @endsection

    <x-slot name="header">
        {{ __('Profile') }}
    </x-slot>

    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Profile') }}</li>
        </ol>
    </x-slot>

    @if(session()->has('success'))
    <div class="successToast"></div>
    @elseif(session()->has('error')) 
        <div class="errorToast"></div>
    @endif
    <div class="" id="successToast"></div>
    <div class="" id="errorToast"></div>

    <div class="row">
        <div class="col-12">
            <div class="card border">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4 bg-light mb-3">
                            <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-right-tab"
                                role="tablist" aria-orientation="vertical">
                                <div class="card card-widget widget-user-2 ">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header elevation-1">
                                        <div class="row" style="position: relative !important;">
                                            <div class="widget-user-image ">
                                                <img class="img-circle elevation-2 user_picture"
                                                    src="{{ Auth::user()->picture }}" alt="User Avatar">
                                            </div>
                                            <div class="btn-group "
                                                style="position: absolute !important; right:0 !important; top:0;">
                                                
                                                <button type="button"
                                                    class="btn btn-default btn-sm dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <i class="fas fa-pen mr-1"></i>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" role="menu" >
                                                    <input type="file" name="user_image" id="user_image"
                                                        accept="image/png, image/gif, image/jpeg"
                                                        style="opacity:0;height:1px;display:none">
                                                    <a href="javascript:void(0)" id="change_picture_btn" class="dropdown-item" href="#"><i class="fas fa-user-edit mr-1"></i><span>{{ __('Change Pictures') }}</span></a>
                                                    @if(Auth::user()->picture != Url('dist/img/users/no-image.jpeg'))
                                                    <form action="{{ route('profile.deletePicture') }}" method="post"
                                                        class="d-inline" id="deleted-picture">
                                                        @csrf
                                                        <button class="dropdown-item" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                            <i class="fas fa-solid fa-trash mr-2"></i><span>{{ __('Delete Pictures') }}</span>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column ml-2">
                                                <!-- /.widget-user-image -->
                                                <div class="d-flex align-items-center justify-between">
                                                    <h3 class="name_user mr-2 mt-1">
                                                        {{-- @if(Str::length( Auth::user()->name) > 12)
                                                            {{ substr( Auth::user()->name, 0, 12) }} ..
                                                        @else
                                                            {{ Auth::user()->name }}
                                                        @endif --}}

                                                        {{ Auth::user()->name }}
                                                    </h3>
                                                    @if(Auth::user()->userPosition->name === 'Owner')
                                                    <small class=" badge badge-info">
                                                        {{ __('Owner') }}
                                                    </small>
                                                    @endif
                                                </div>
                                                <p class="user_email" style="margin-top: -10px !important">{{ Auth::user()->email }} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="nav-link active" id="vert-tabs-right-personal-information-tab"
                                    data-toggle="pill" href="#vert-tabs-right-personal-information" role="tab"
                                    aria-controls="vert-tabs-right-personal-information"
                                    aria-selected="false">{{ __('Personal Information') }}</a>
                                <a class="nav-link " id="vert-tabs-right-settings-tab" data-toggle="pill"
                                    href="#vert-tabs-right-settings" role="tab" aria-controls="vert-tabs-right-settings"
                                    aria-selected="false">{{ __('Settings Account') }}</a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="tab-content" id="vert-tabs-right-tabContent">
                                <div class="tab-pane fade show active" id="vert-tabs-right-personal-information" role="tabpanel" aria-labelledby="vert-tabs-right-personal-information-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            {{ __('Personal Information') }}
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-unbordered " style="list-style-type: none;">
                                                <li class="d-lg-flex align-items-center ">
                                                    <p class="col-lg-4 ">{{ __('Name') }}</p>
                                                    <p class="col-lg-8 text-bold"> {{ Auth::user()->name }}</p>
                                                </li>
                                                <li class="d-lg-flex align-items-center">
                                                    <p class="col-lg-4 ">{{ __('Gender') }}</p>
                                                    <p class="col-lg-8 text-bold">
                                                        @if(Auth::user()->gender == 'M')
                                                        {{ __('Male') }}
                                                        @else
                                                        {{ __('Female') }}
                                                        @endif
                                                    </p>
                                                </li>
                                                <li class="d-lg-flex align-items-center">
                                                    <p class="col-lg-4 ">{{ __('Email') }}</p>
                                                    <p class="col-lg-8 text-bold"> {{ Auth::user()->email }}</p>
                                                </li>
                                                <li class="d-lg-flex align-items-center">
                                                    <p class="col-lg-4 ">{{ __('Telp') }}</p>
                                                    <p class="col-lg-8 text-bold"> {{ Auth::user()->telp }}</p>
                                                </li>
                                                <li class="d-lg-flex align-items-center">
                                                    <p class="col-lg-4 ">{{ __('Address') }}</p>
                                                    <p class="col-lg-8 text-bold"> {{ Auth::user()->address }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-right-settings" role="tabpanel"
                                    aria-labelledby="vert-tabs-right-settings-tab">
                                    <div class="card">
                                        <div class="card-header p-2">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item"><a class="nav-link active" href="#personal_information" data-toggle="tab">{{ __('Personal Information') }}</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">{{ __('Change Password') }}</a></li>
                                            </ul>
                                        </div><!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="active tab-pane" id="personal_information">
                                                    <form class="form-horizontal" id="fromInfo" method="POST"
                                                        action="{{ route('profile.update') }}">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label for="inputName"
                                                                class="col-sm-3 col-form-label ">{{ __('Name') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control error_input_name" id="inputName"
                                                                    placeholder="{{ __('Enter') }} {{ __('Name') }}"
                                                                    value="{{ Auth::user()->name }}" name="name">
                                                                <span class="text-danger error-text name_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputEmail"
                                                                class="col-sm-3 col-form-label">{{ __('Email') }} <span
                                                                    class="text-danger">*</span></label></label>
                                                            <div class="col-sm-9">
                                                                <input type="email" class="form-control" id="inputEmail"
                                                                    disabled
                                                                    placeholder="{{ __('Enter') }} {{ __('Email') }}"
                                                                    value="{{ Auth::user()->email }}" name="email">
                                                                <span class="text-danger error-text email_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="InputNoHp"
                                                                class="col-sm-3 col-form-label">{{ __('Number Phone') }} <span
                                                                class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">+62</span>
                                                                    </div>
                                                                    <input class="form-control square error_input_telp"
                                                                        name="telp" type="number" min="0"
                                                                        placeholder="{{ __('Enter') }} {{ __('Store Contact') }}"
                                                                        value="{{ Auth::user()->telp }}">
                                                                </div>
                                                                <span class="text-danger error-text telp_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputGender"
                                                                class="col-sm-3 col-form-label">{{ __('Gender') }} <span
                                                                class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control error_input_gender"
                                                                style="width: 100%;" name="gender" id="gender">
                                                                @if(Auth::user()->gender === 'M')
                                                                <option value="M" selected="selected">{{ __('Male') }}</option>
                                                                <option value="F">{{ __('Female') }}</option>
                                                                @elseif(Auth::user()->gender === 'F')
                                                                <option value="M" >{{ __('Male') }}</option>
                                                                <option value="F" selected="selected">{{ __('Female') }}</option>
                                                                @else
                                                                <option selected="selected" disabled>{{ __('Choose Your Gender') }}</option>
                                                                <option value="M" >{{ __('Male') }}</option>
                                                                <option value="F" >{{ __('Female') }}</option>
                                                                @endif
                                                                </select>
                                                                <span class="text-danger error-text gender_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="InputAddress"
                                                                class="col-sm-3 col-form-label">{{ __('Address') }}</label>
                                                            <div class="col-sm-9">
                                                                <textarea class="form-control error_input_address" id="InputAddress"
                                                                    name="address" cols="30" rows="2"
                                                                    placeholder="{{ __('Enter') }} {{ __('Address') }}">{{ Auth::user()->address }}</textarea>
                                                                <span
                                                                    class="text-danger error-text address_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="offset-sm-3 col-sm-9">
                                                                <button type="submit"
                                                                    class="btn btn-danger float-sm-right mt-4">{{ __('Save Changes') }}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="change_password">
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('profile.changePassword') }}" id="changePasswordForm">
                                                        <div class="form-group row">
                                                            <label for="inputName"
                                                                class="col-sm-4 col-form-label">{{ __('Old Password') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="password" class="form-control error_input_oldpassword"
                                                                    id="inputName"
                                                                    placeholder="{{ __('Enter') }} {{ __('Old Password') }}"
                                                                    name="oldpassword">
                                                                <span
                                                                    class="text-danger error-text oldpassword_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputName3"
                                                                class="col-sm-4 col-form-label">{{ __('New Password') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="password" class="form-control error_input_newpassword"
                                                                    id="inputName3"
                                                                    placeholder="{{ __('Enter') }} {{ __('New Password') }}"
                                                                    name="newpassword">
                                                                <span
                                                                    class="text-danger error-text newpassword_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputEmail"
                                                                class="col-sm-4 col-form-label">{{ __('Confirm New Password') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="password" class="form-control error_input_cnewpassword"
                                                                    id="inputEmail"
                                                                    placeholder="{{ __('Enter') }} {{ __('Confirm New Password') }}"
                                                                    name="cnewpassword">
                                                                <span
                                                                    class="text-danger error-text cnewpassword_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="offset-sm-4 col-sm-8">
                                                                <button type="submit"
                                                                    class="btn btn-danger float-sm-right mt-4">{{ __('Update Password') }}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.tab-pane -->
                                            </div>
                                            <!-- /.tab-content -->
                                        </div><!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        @section('scripts')
        <!-- Select 2 -->
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <!-- Ijabo Crop Tool -->
        <script src="{{ asset('plugins/ijabo-crop-tool/ijaboCropTool.min.js') }}"></script>

        <script>
            $(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $('.select2').select2()

                $('#fromInfo').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: new FormData(this),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        withCSRF: ['_token', '{{ csrf_token() }}'],
                        beforeSend: function () {
                            $(document).find('span.error-text').text('');
                        },
                        success: function (data) {
                            if (data.status == 0) {
                                $.each(data.error, function (prefix, val) {
                                    $('span.' + prefix + '_error').text(val[0]);
                                    $('input.error_input_' + prefix).addClass('is-invalid');
                                    $('textarea.error_input_' + prefix).addClass('is-invalid');
                                    $('select.error_input_' + prefix).addClass('is-invalid');
                                });
                                $('#errorToast').addClass("errorToast");
                                return $('.errorToast').each(function () {
                                    Toast.fire({
                                        icon: 'error',
                                        title: data.msg
                                    })
                                });
                            } else {
                                $('.name_user').each(function () {
                                    $(this).html($('#fromInfo').find($(
                                        'input[name="name"]')).val());
                                });
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire(
                                xhr.statusText,
                                '{{ __('Wait a few minutes to try again') }}',
                                'error'
                            )
                        }
                    });
                });

                $('#changePasswordForm').on('submit', function (e) {
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
                                });
                                $('#errorToast').addClass("errorToast");
                                return $('.errorToast').each(function () {
                                    Toast.fire({
                                        icon: 'error',
                                        title: data.msg
                                    })
                                });
                            } else {
                                $('#changePasswordForm')[0].reset();
                                $('input.error_input_oldpassword').removeClass('is-invalid');
                                $('input.error_input_newpassword').removeClass('is-invalid');
                                $('input.error_input_cnewpassword').removeClass('is-invalid');
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire(
                                xhr.statusText,
                                '{{ __('Wait a few minutes to try again') }}',
                                'error'
                            )
                        }
                    });
                });

                $(document).on('click', '#change_picture_btn', function () {
                    $('#user_image').click();
                });

                $('#user_image').ijaboCropTool({
                    preview: '.user_picture',
                    setRatio: 1,
                    allowedExtensions: ['jpg', 'jpeg', 'png'],
                    buttonsText: ['{{ __("Crop") }}', '{{ __("Cancel") }}'],
                    buttonsColor: ['#28A745', '#DC3545', -15],
                    processUrl: '{{ route("profile.pictureUpdate") }}',
                    // withCSRF:['_token','{{ csrf_token() }}'],
                    onSuccess: function (message, element, status) {
                        $('#successToast').addClass("successToast");
                        return $('.successToast').each(function () {
                            Toast.fire({
                                icon: 'success',
                                title: message
                            })
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000);
                        });
                    },
                    onError: function (message, element, status) {
                        $('#errorToast').addClass("errorToast");
                        return $('.errorToast').each(function () {
                            Toast.fire({
                                icon: 'error',
                                title: message
                            })
                        });
                    }
                });

            });


           

            // function deletedImage() {
            //     Swal.fire({
            //             title: "{{ __('Are You Sure') }}",
            //             text: "{{ __('You wont be able to revert this') }}",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#6F42C1',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: "{{ __('Yes, deleted it') }}",
            //             cancelButtonText: "{{ __('Cancle') }}", 
            //             }).then((result) => {
            //             if (result.isConfirmed) {
            //                 $.ajax({
            //                     url: "{{ route('profile.deletePicture') }}",
            //                     method: "post",
            //                     data: {}
            //                     dataType: "html",
            //                     success: function () {
            //                         alert("Done!", "It was succesfully deleted!", "success");
            //                     },
            //                     error: function (xhr, ajaxOptions, thrownError) {
            //                         alert("Error deleting!", "Please try again", "error");
            //                 }
            //             });
            //         }
            //     })
            // }
        </script>

        @endsection

</x-app-dashboard>
