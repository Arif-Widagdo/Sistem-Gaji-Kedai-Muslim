<x-guest-layout title="{{ __('Verify Email') }}">
    <div class="card-header py-2 border-purple">
        <h4 style="font-family: 'Poppins', cursive; font-weight: 700 !important;">{{ __('Verify Email') }}</h4>
        <p class="mt-4" style="font-family: 'Poppins', cursive; font-weight: 500 !important;">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didnt receive the email, we will gladly send you another.') }}
        </p>
    </div>
    <div class="card-body ">
        @if(session()->has('status'))
        <div class="card p-1 text-dark bg-transparent border">
            <span><i class="fas fa-info-circle text-purple"></i> <strong>{{ session('status') }}</strong></span> 
        </div>
        @endif
        <div class="row">
            <form method="POST" action="{{ route('verification.send') }}" class="col-6 d-flex justify-content-start">
                @csrf
                <button type="submit" class="btn bg-purple ">{{ __('Resend Verification Email') }}</button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="col-6 d-flex justify-content-end">
                @csrf
                <button type="submit" class="btn btn-default">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
</x-guest-layout>