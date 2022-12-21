<form action="{{ route('owner.sallary.store') }}" method="POST" id="form_create_sallary">
    @csrf
    <input type="hidden" name="id_user" id="id_user" value="{{ $user->id }}" required="required" >
    <input type="hidden" value="{{ request('periode') }}" name="periode">
    <input type="hidden" name="quantity" id="quantity" value="{{ $quantity }}" required="required" >
    <input type="hidden" name="total" id="total" value="{{ $totalCost }}" required="required" >
    <input type="hidden" name="payment_status" id="payment_status" value="{{ request('payment_status') }}" required="required">
    <div class="row no-print">
        <div class="col-12">
            @if($id_exist == '')
            <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i>
                {{ __('Save') }}
            </button>
            @endif
            <a href="{{ route('owner.sallary.print') }}?email={{ request('email') }}&periode={{ request('periode') }}&payment_status={{ request('payment_status') }}" 
                rel="noopener" target="_blank" 
                class="btn btn-primary float-right"
                style="margin-right: 5px;">
                <i class="fas fa-print"></i> {{ __('Print') }}
            </a>
        </div>
    </div>
</form>