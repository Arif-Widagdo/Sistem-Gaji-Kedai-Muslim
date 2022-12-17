<x-guest-layout title="{{ __('Confirm Password') }}">
    <div class="card-header py-2 border-info">
        <h4 style="font-family: 'Poppins', cursive; font-weight: 700 !important;">{{ __('Confirm Password') }}</h4>
        <p class="mt-4" style="font-family: 'Poppins', cursive; font-weight: 500 !important;">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
        <div class="text-danger text-sm text-bold">
            {{ __('* required fileds') }}
        </div>
    </div>
    <form class="form-horizontal" action="{{ route('password.confirm') }}" method="POST">
        @csrf
        <div class="card-body ">
            <div class="form-group mb-4">
                <label for="password" class="col-form-label">{{ __('Password') }} <span class="text-danger text-bold">*</span></label>
                <span class="text-danger text-bold error-text password_error"></span>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                </div>
                @error('password')
                <span class="text-danger error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="modal-footer justify-content-between border-info">
            <a href="{{ route('register') }}" class="btn btn-default">{{ __('Register') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
        </div>
    </form>
</x-guest-layout>