<x-app-dashboard title="{{ __('Sallary Recap') }} {{ $periode }}">

    <x-slot name="header">
        {{ __('Sallary Recap') }} {{ $periode }}
    </x-slot>
    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="{{ route('recap.sallary.index') }}">{{ __('Sallary Recap') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Sallary Recap') }} {{ $periode }}</li>
        </ol>
    </x-slot>

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
                                        <h4 class="page-header text-bold">
                                            {{ __('Sallary Recap') }} {{ $periode }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>{{ __('User Names')}} </th>
                                            <th>{{ __('Quantities') }}</th>
                                            <th>{{ __('Subtotal') }}</th>
                                            {{-- <th>{{ __('Payment Time') }}</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sallaries as $sallary)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sallary->userSallary->name }}</td>
                                                <td>{{ $sallary->quantity }}</td>
                                                <td>Rp. {{ number_format($sallary->total,2,',','.') }}</td>
                                                {{-- <td>{{ Carbon\Carbon::parse($sallary->payroll_time)->translatedFormat('l, d F Y'); }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border">
                                        <tr class="">
                                            <td colspan="2">
                                                <b>Total</b>
                                            </td>
                                            <td>
                                                <b>{{ $sallary->sum('quantity') }} Item</b>
                                            </td>
                                            <td>
                                                <b class="mr-4">Rp. {{ number_format($sallary->sum('total'),2,',','.') }}</b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="card-footer">
                    <div class="row no-print">
                        <div class="col-12">
                            <a href="{{ route('recap.sallary.index') }}" rel="noopener" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> {{ __('Back') }}</a>
                            <a href="{{ route('recap.sallary.print', $periode) }}" 
                                rel="noopener" target="_blank" 
                                class="btn btn-primary float-right"
                                style="margin-right: 5px;">
                                <i class="fas fa-print"></i> {{ __('Print') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   


</x-app-dashboard>




