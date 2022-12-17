<x-guest-layout title="{{ __('Forgot Password') }}">
    <div class="card-header py-2 border-purple">
        <h4 style="font-family: 'Poppins', cursive; font-weight: 700 !important;">{{ __('Forgot Password') }}</h4>
        <p class="mt-4" style="font-family: 'Poppins', cursive; font-weight: 500 !important;">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
        <div class="text-danger text-sm text-bold">
            {{ __('* required fileds') }}
        </div>
    </div>
    <form class="form-horizontal" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="card-body ">
            @if(session()->has('status'))
            <div class="card p-1 text-dark bg-transparent border">
                <span><i class="fas fa-check-circle text-success"></i> <strong>{{ session('status') }}</strong></span>
            </div>
            @endif
            <div class="form-group mb-1">
                <label for="email" class="col-form-label">{{ __('Email') }} <span class="text-danger text-bold">*</span></label>
                <span class="text-danger text-bold error-text email_error"></span>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                <span class="text-danger error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="modal-footer justify-content-between border-purple">
            <a href="{{ route('login') }}" class="btn btn-default">{{ __('Cancel') }}</a>
            <button type="submit" class="btn bg-purple ">{{ __('Email Password Reset Link') }}</button>
        </div>
    </form>
</x-guest-layout>