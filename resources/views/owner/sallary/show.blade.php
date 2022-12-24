<x-app-dashboard title="{{ __('Invoice Histories') }}">
    @section('links')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection
   
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-purple">
                <!-- Main content -->
                <div class="card-body">
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-end">
                                        <img src="{{ asset('dist/img/logos/purpleLogo.png') }}" alt="" width="80" class="mr-2"> 
                                        <h3 class="page-header" style="font-family: 'Kalam', cursive; font-weight: 700 !important; line-height:25px; ">
                                            Kedai Muslim <br>
                                            Collection
                                        </h3>
                                    </div>
                                    <div class="col-6 d-flex align-items-center justify-content-end">
                                        <h3 class="page-header" style="font-family: 'Kalam', cursive; font-weight: 700 !important; line-height:25px; ">
                                            {{ __('Salary in') }} {{ $sallaryMonth }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info mt-4">
                            <div class="col-sm-5 invoice-col">
                            {{ __('From') }}
                                <address>
                                    <strong>Kedai Muslim</strong><br>
                                    Sidomulyo, South Lampung Regency<br>
                                    Lampung 35353<br>
                                    (+62) 812-7920-2340
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-5 invoice-col">
                                {{ __('To') }}
                                <address>
                                    <strong>{{ $user->email }}</strong><br>
                                    @if($user->telp)
                                    {{ $user->telp }}<br>
                                    @endif
                                    <p class="col-8 p-0 m-0">{{ $user->address }}</p>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 invoice-col">
                                {{ __('Date') }}:
                                <address>
                                    <strong>{{ now()->format('d, F Y') }}</strong>
                                </address>
                            </div>
                        </div>
                        <!-- /.row -->
                        @include('components.invoice.table_invoice')
                    </div>
                </div>

                <div class="card-footer">
                    @if($products)
                        @if($products->count() > 0)
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{ route('owner.sallary.index') }}" rel="noopener" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> {{ __('Back') }}</a>
                                    <a href="{{ route('owner.sallary.print') }}?email={{ $user->email }}&periode={{ $periode }}" 
                                        rel="noopener" target="_blank" 
                                        class="btn btn-primary float-right"
                                        style="margin-right: 5px;">
                                        <i class="fas fa-print"></i> {{ __('Print') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div><!-- /.row -->


</x-app-dashboard>