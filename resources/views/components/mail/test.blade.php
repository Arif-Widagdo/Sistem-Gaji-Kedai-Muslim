<x-mail-layout>
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-end">
                <img src="{{ $message->embed('dist/img/logos/purpleLogo.png') }}" alt="" width="80" class="mr-2">
                <h3 class="page-header"
                    style="font-family: 'Kalam', cursive; font-weight: 700 !important; line-height:25px; ">
                    Kedai Muslim <br>
                    Collection
                </h3>
            </div>
        </div>
    </div>
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
        <div class="col-sm-5 invoice-col">
            {{ __('To') }}
            <address>
                <strong>{{ $isi_email['user']->email }}</strong><br>
                @if($isi_email['user']->telp)
                {{ $isi_email['user']->telp }}<br>
                @endif
                <p class="col-8 p-0 m-0">{{ $isi_email['user']->address }}</p>
            </address>
        </div>
        <div class="col-sm-2 invoice-col">
            {{ __('Date') }}:
            <address>
                <strong>{{ now()->format('d, F Y') }}</strong>
                @if($isi_email['status'] !== '')
                <div class="mt-1">
                    @if($isi_email['status'] == 'paid')
                    <img src="{{ $message->embed('dist/img/lunas.png') }}" alt="{{ __('Paid') }}" style="width: 35%;">
                    @elseif($isi_email['status'] == 'not_paid')
                    <img src="{{ $message->embed('dist/img/tidak.png') }}" alt="{{ __('Paid') }}" style="width: 35%;">
                    @endif
                </div>
                @endif
            </address>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>{{ __('Product Category') }}</th>
                        <th>{{ __('Quantities') }}</th>
                        <th>{{ __('Subtotal') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($isi_email['products'])
                    @if($isi_email['products']->count() > 0)
                    @foreach ($isi_email['products'] as $key => $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <!---- Category Name ---->
                        @foreach ($isi_email['categories']->where('id', $key) as $category)
                        <td>
                            {{ $category->name }}
                        </td>
                        @endforeach
                        <!---- Quantity ---->
                        <td>{{ $product->sum('quantity') }} Item</td>
                        <!---- Sub Total ---->
                        @foreach ($isi_email['services']->where('id_category', $category->id) as $service)
                        <td>
                            Rp. {{ number_format($service->sallary*$product->sum('quantity'),2,',','.') }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center">Data Perkerjaan Kosong, Mungkin Dia Lelah</td>
                    </tr>
                    @endif
                    @endif
                    </tr>
                </tbody>
                @if($isi_email['products'])
                @if($isi_email['products']->count() > 0)
                <tfoot class="border">
                    <tr class="">
                        <td colspan="2">
                            <b>Total</b>
                        </td>
                        <td>
                            <b>{{ $isi_email['quantity'] }} Item</b>
                        </td>
                        <td>
                            <b class="mr-4">Rp. {{ number_format($isi_email['totalCost'],2,',','.') }}</b>
                        </td>
                    </tr>
                </tfoot>
                @endif
                @endif
            </table>
        </div>
    </div>

</x-mail-layout>