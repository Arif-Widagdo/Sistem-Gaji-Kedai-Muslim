<x-app-dashboard title="{{ __('Dashboard') }}">

    <div class="row" >
        <div class="col-lg-6">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jumlah Produk yang dikerjakan Bulan {{ $monthNow}}</span>
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
                    <span class="info-box-text">Gaji yang diperkirakan pada Bulan {{ $monthNow}}</span>
                    <span class="info-box-number">
                       Rp. {{ number_format( $totalCost,2,',','.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Timelime example  -->
    <div class="row">
        <div class="col-md-12">
            @if($products->count() > 0)
            <div class="row ">
                <div class="col-lg-12">
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
                </div>


            </div>

            @else
            Yahh Kerjaan mu masih kosong, Ayoo kerja dan laporkan ke owner..
            @endif
        </div>
    </div>

    <!-- /.timeline -->


</x-app-dashboard>
