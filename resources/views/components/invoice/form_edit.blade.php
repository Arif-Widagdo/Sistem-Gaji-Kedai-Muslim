@if($status_exist == 'not_paid')
<form action="{{ route('owner.sallary.update', $id_exist) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row no-print">
        <div class="col-12">
            <button type="submit" class="btn bg-purple float-right"><i class="far fa-credit-card"></i>
                {{ __('Bayar') }}
            </button>
            <a href="{{ route('owner.sallary.print') }}?email={{ request('email') }}&periode={{ request('periode') }}&payment_status={{ request('payment_status') }}"
                rel="noopener" target="_blank" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-print"></i> {{ __('Print') }}
            </a>
        </div>
    </div>
</form>
@endif