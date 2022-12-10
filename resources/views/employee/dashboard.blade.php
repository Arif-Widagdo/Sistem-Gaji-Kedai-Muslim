<x-app-dashboard title="{{ __('Dashboard') }}">

    <!-- Timelime example  -->
    <div class="row">
        <div class="col-md-12">
            @if($products->count() > 0)
            <div class="row">
                @foreach ($products as $product)
                <div class="col-lg-6">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-white" style="color: #6F42C1 !important; border:2px solid #6F42C1 !important;">{{ $product->completed_date }}</span>
                        </div>
                        <div>
                            <i class="fas fa-hand-holding-usd bg-purple"></i>
                            <div class="timeline-item overflow-hidden" >
                                {{-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> --}}
                                <h3 class="timeline-header bg-purple">{{ $product->category->name }}</h3>
                                <div class="timeline-body">
                                    <p class="d-flex justify-content-between align-items-center w-100">
                                        <span class="col-4">Jumlah</span>: 
                                        <span class="text-bold col-8">{{ $product->count }}</span>
                                    </p>
                                    @foreach ($services->where('id_category', '=', $product->category->id) as $service)
                                        <p class="d-flex justify-content-between align-items-center w-100">
                                            <span class="col-4">Harga Satuan</span>: 
                                            <span class="text-bold col-8">Rp. {{ number_format( $service->sallary,2,',','.') }}</span>
                                        </p>
                                        <hr>
                                        <p class="d-flex justify-content-between align-items-center w-100">
                                            <span class="col-4">Total</span>: 
                                            <span class="text-bold col-8">Rp. {{ number_format( $product->count*$service->sallary,2,',','.') }}</span>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
          
            @else
            Yahh Kerjaan mu masih kosong, Ayoo kerja dan laporkan ke owner..
            @endif
        </div>
    </div>

    <!-- /.timeline -->


</x-app-dashboard>
