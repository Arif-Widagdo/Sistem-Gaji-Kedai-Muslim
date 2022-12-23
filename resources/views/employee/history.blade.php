<x-app-dashboard title="{{ __('Histories') }}">
    @section('links')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    @endsection

    <x-slot name="header">
        Pencarian Riwayat Pekerjaan
    </x-slot>
    {{-- <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('Category Management') }}</li>
        </ol>
    </x-slot> --}}

    <div class="row">
        <div class="col-12">
            <form action="{{ route('employee.history') }}" action="get">
                <div class="card card-outline card-purple bg-light">
                    <div class="card-body border">
                        <div class="row">
                            <div class="form-group col-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation" name="search" >
                                </div>
                                {{-- <small class="text-danger text-bold" style="padding-left: 52px;">Ex : 2001/01/28 - 2012/12/01 </small> --}}
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn bg-purple text-bold w-100">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    @if($from && $to)
    <div class="row">
        <div class="col-12">
            <div class="card bg-light" style="border-bottom: 2px solid #6F42C1;">
                <div class="card-body text-center">
                    <div class="mx-auto text-purple">
                        <h5>
                            Laporan Pencarian dari Hari <b>{{ $from }}</b> sampai Hari <b>{{ $to }}</b>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($quantityWorked && $totalCost)
    <div class="row" >
        <div class="col-lg-6">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jumlah Produk yang dikerjakan</span>
                    <span class="info-box-number">
                        {{ $quantityWorked }} Item
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jumlah Penghasilan yang di dapatkan </span>
                    <span class="info-box-number">
                    Rp. {{ number_format( $totalCost,2,',','.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($products)
    <div class="row ">
        <div class="col-lg-12">
        @if($products->count() > 0)
        @foreach ($products as $key => $products)
            <div class="timeline">
                <div class="time-label">
                    <span class="bg-white" style="color: #6F42C1 !important; border:1px solid #6F42C1 !important;">
                        <i class="fas fa-clock"></i> {{ $key }}
                    </span>
                </div>
                @foreach ($products as $product)
                <div>
                    <i class="fas fa-wallet  bg-purple"></i>
                    <div class="timeline-item overflow-hidden">
                        <h3 class="timeline-header bg-purple"><i class="fas fa-list"></i>
                            {{ $product->category->name }}</h3>
                        <div class="timeline-body">
                            <ul class="p-0">
                                <li>
                                    <p class="d-flex justify-content-between align-items-center w-100"
                                        style="line-height: 0;">
                                        <span class="col-4">Nama Produk</span>:
                                        <span class="text-bold col-8">{{ $product->name }}</span>
                                    </p>
                                </li>
                                <li>
                                    <p class="d-flex justify-content-between align-items-center w-100"
                                        style="line-height: 0;">
                                        <span class="col-4">Jumlah</span>:
                                        <span class="text-bold col-8">{{ $product->quantity }}</span>
                                    </p>
                                </li>
                                <li>
                                    @foreach ($services->where('id_category', '=', $product->category->id) as $service)
                                    <p class="d-flex justify-content-between align-items-center w-100" style="line-height: 0;">
                                        <span class="col-4">Harga Satuan</span>:
                                        <span class="text-bold col-8">Rp. {{ number_format( $service->sallary,2,',','.') }}</span>
                                    </p>
                                    <hr>
                                    <p class="d-flex justify-content-between align-items-center w-100">
                                        <span class="col-4">Total</span>:
                                        <span class="text-bold col-8">Rp. {{ number_format( $product->quantity*$service->sallary,2,',','.') }}</span>
                                    </p>
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
        @else
        <div class="row " style="margin-bottom: 20px;">
            <div class="col-12">
                <div class="d-flex flex-md-row flex-column justify-content-center align-items-center">
                    <img src="{{ asset('dist/img/emoji/bingung.webp') }}" alt="Kok Kosong?" width="350">
                    {{-- Data Tidak Ada --}}
                    <div class="text-md-left text-center">
                        <h1 class="text-bold" style="font-family: 'Nunito';">Data Tidak Ada</h1>
                        <p class="m-0 ">
                            Mungkin Anda Belum Bekerja Pada Tanggal yang Dicari. <br>
                            Atau Mungkin Anda Lelah? <span class="h5 text-bold">Ayoo Semangat Lagi Kerjanya, <br> Sadar Kalo Kamu Tuh...</span>
                            <small class="text-light">
                                @if(auth()->user()->gender == 'F')
                                Cantik
                                @else
                                Ganteng
                                @endif
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        </div>
    </div>
    @endif
        
    @section('scripts')
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script>
        //Date range picker
        // $('#reservation').daterangepicker()
        // $('#reservation').daterangepicker({
        //     timePicker: false,
        //     locale: {
        //         format: 'YYYY-MM-DD'
        //     },
        // })

        $('#reservation').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD'
            },
            startDate: moment().subtract(1, 'year'),
            // endDate  : moment()
            
        })

    </script>
    @endsection


</x-app-dashboard>
