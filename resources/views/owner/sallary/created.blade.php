<x-app-dashboard title="Buat Gaji">
    @section('links')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection

    <x-slot name="header">
        Buat Gaji
    </x-slot>
    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="{{ route('owner.sallary.index') }}">Daftar Gaji</a></li>
            <li class="breadcrumb-item active">Buat Gaji</li>
        </ol>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('owner.sallary.create') }}">
                <div class="card card-outline">
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
                            <div class="form-group col-sm-4 mb-1 border pb-2">
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
                            <div class="form-group col-sm-4 mb-1 border pb-2">
                                <label for="periode" class="col-form-label">{{ __('Periode') }} <span class="text-danger">*</span></label>
                                <input type="month" id="periode" class="form-control error_input_periode" value="{{ request('periode') }}" required="required" name="periode" onchange="submitButton()">
                                <span class="text-danger error-text periode_error"></span>
                            </div>
                            <div class="form-group col-sm-4 mb-1 border pb-2">
                                <label for="payment_status" class="col-form-label">{{ __('Payment Status') }} <span class="text-danger">*</span></label>
                                <select id="payment_status" name="payment_status" required  class="form-control" onchange="submitButton()">
                                    <option value="" disabled selected>{{ __('Select Status') }}</option>
                                    @if(request('payment_status') == 'not_paid')
                                        <option value="not_paid" selected>{{ __('Not Paid') }}</option>
                                        <option value="paid">{{ __('Paid') }}</option>
                                    @elseif(request('payment_status') == 'paid')
                                        <option value="paid" selected>{{ __('Paid') }}</option>
                                        <option value="not_paid">{{ __('Not Paid') }}</option>
                                    @else
                                        <option value="paid">{{ __('Paid') }}</option>
                                        <option value="not_paid">{{ __('Not Paid') }}</option>
                                    @endif
                                </select>
                                <span class="text-danger error-text payment_status_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border d-flex justify-content-end">
                        <a href="{{ route('owner.sallary.index') }}" 
                        class="btn btn-default "
                        style="margin-right: 5px;">
                        {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn bg-purple float-right" id="filterSallary">{{ __('Submit') }}</button>
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
                            @if($status_exist == 'paid' || $status_exist == '')
                                @include('components.invoice.form_create')
                            @else
                                @if($status_exist !== '' && $id_exist !== '')
                                    @include('components.invoice.form_edit')
                                @endif
                            @endif
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

        $('#form_create_sallary').on('submit', function (e) {
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
                    alertToastInfo(data.msg)
                    }  else if (data.status == 'exists') {
                    alertToastError(data.msg)
                    } else {
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