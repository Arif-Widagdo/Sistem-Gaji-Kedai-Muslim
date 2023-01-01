<x-app-dashboard title="{{ __('Create Sallary') }}">
    @section('links')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection

    <x-slot name="header">
        {{ __('Create Sallary') }}
    </x-slot>
    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="{{ route('owner.sallary.index') }}">{{ __('Pay List') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Create Sallary') }}</li>
        </ol>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('owner.sallary.create') }}">
                <div class="card card-outline card-purple">
                    <div class="card-body border">
                        @if($status == __('Please complete the input on the form provided'))
                        <div class="row">
                            <p>
                                <b class="text-danger">
                                    {{ $status }}
                                </b>
                            </p>
                        </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-sm-6 mb-1 border pb-2">
                                <label for="email" class="col-form-label">{{ __('Worker') }} <span class="text-danger">*</span></label>
                                <select name="email" id="email" class="form-control select2" required style="width: 100%;" onchange="submitButton()">
                                    <option value="" disabled selected>{{ __('Select Worker') }}</option>
                                    @foreach ($workers as $worker)
                                        @if(request('email') == $worker->email)
                                        <option value="{{ $worker->email }}" selected>{{ $worker->name }}</option>
                                        @else
                                        <option value="{{ $worker->email }}">{{ $worker->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="form-group col-sm-6 mb-1 border pb-2">
                                <label for="periode" class="col-form-label">{{ __('Periode') }} <span class="text-danger">*</span></label>
                                <input type="month" id="periode" class="form-control error_input_periode" value="{{ request('periode') }}" required="required" name="periode" onchange="submitButton()">
                                <span class="text-danger error-text periode_error"></span>
                            </div>
                        </div>
                        <button type="submit" class="d-none" id="filterSallary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @if($user)
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-purple">
                <!-- Main content -->
                <div class="card-body">
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        @include('components.invoice.header_invoice')
                        <!-- Table row -->
                        @include('components.invoice.table_invoice')
                    </div>
                </div>

                <div class="card-footer">
                    @if($products)
                        @if($products->count() > 0)
                            @include('components.invoice.form_create')
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div><!-- /.row -->
    @endif


    @section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- Customs for pages -->
    <script>
        $('.select2').select2()

        function submitButton(){
            $("#filterSallary").click();
        }

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
        //                     $('span.' + prefix + '_error').text(val[0]);
        //                     $('input.error_input_' + prefix).addClass('is-invalid');
        //                 });
        //             alertToastInfo(data.msg)
        //             }  else if (data.status == 'exists') {
        //             alertToastError(data.msg)
        //             } else {
        //                 setTimeout(function () {
        //                     location.reload(true);
        //                 }, 1000);
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