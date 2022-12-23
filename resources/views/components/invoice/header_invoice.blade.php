<!-- title row -->
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-end">
            <img src="{{ asset('dist/img/logos/purpleLogo.png') }}" alt="" width="80" class="mr-2"> 
            <h3 class="page-header" style="font-family: 'Kalam', cursive; font-weight: 700 !important; line-height:25px; ">
                Kedai Muslim <br>
                Collection
            </h3>
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