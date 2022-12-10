<x-app-dashboard title="{{ __('Dhasboard') }}">

    <div class="card">
        <div class="card-header">
            Test
        </div>
        <div class="card-body">
            <div class="row">
                <ul class="col-12">
                    <h1>INI PRODUK</h1>
                    @foreach ($products as $product)
                    <li>
                        <p><span class="text-bold">Kategori Produk</span> : {{ $product->category->name }}</p>
                    </li>
                    <li>
                        <p><span class="text-bold">Jumlah</span> : {{ $product->count }}</p>
                    </li>
                    <li>
                        <p><span class="text-bold">Tanggal</span> : {{ $product->completed_date }}</p>
                    </li>
                        @foreach ($services->where('id_category', '=', $product->category->id) as $service)
                        <li>
                            <p><span class="text-bold">Harga Satuan</span> : {{ $service->sallary }}</p>
                        </li>
                        <li>
                            <p><span class="text-bold">Total</span> : {{ $product->count*$service->sallary }}</p>
                        </li>
                        @endforeach
                    <hr>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-dashboard>
