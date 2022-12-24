<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-striped" >
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Product Category') }}</th>
                    <th>{{ __('Quantities') }}</th>
                    <th>{{ __('Subtotal') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($products)
                    @if($products->count() > 0)
                        @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <!---- Category Name ---->
                            @foreach ($categories->where('id', $key) as $category)
                            <td>
                                {{ $category->name }}
                            </td>
                            @endforeach
                            <!---- Quantity ---->
                            <td>{{ $product->sum('quantity') }} Item</td>
                            <!---- Sub Total ---->
                            @foreach ($services->where('id_category', $category->id) as $service)
                            <td>
                                Rp. {{ number_format($service->sallary*$product->sum('quantity'),2,',','.') }}
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">{{ __('Data is Empty') }}, {{ __('You Need to Calm Down') }}</td>
                        </tr>
                    @endif
                @endif
                </tr>
            </tbody>
            @if($products)
                @if($products->count() > 0)
                <tfoot class="border">
                    <tr class="">
                        <td colspan="2">
                            <b>Total</b>
                        </td>
                        <td>
                            <b>{{ $quantity }} Item</b>
                        </td>
                        <td>
                            <b class="mr-4">Rp. {{ number_format($totalCost,2,',','.') }}</b>
                        </td>
                    </tr>
                </tfoot>
                @endif
            @endif
        </table>
    </div>
</div>