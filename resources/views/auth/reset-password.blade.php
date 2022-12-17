<x-guest-layout title="{{ __('Reset Password') }}">
    <div class="card-header py-2 border-purple">
        <h4 style="font-family: 'Poppins', cursive; font-weight: 700 !important;">{{ __('Reset Password') }}</h4>
        <div class="text-danger text-sm text-bold">
            {{ __('* required fileds') }}
        </div>
    </div>
    <form class="form-horizontal" action="{{ route('password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="card-body ">
            @if(session()->has('status'))
            <div class="card p-1 text-danger bg-transparent border">
                <span><i class="fas fa-info-circle"></i> <strong>{{ session('status') }}</strong></span>
            </div>
            @endif
            <div class="form-group mb-1">
                <label for="email" class="col-form-label">{{ __('Email') }} <span class="text-danger text-bold">*</span></label>
                <span class="text-danger text-bold error-text email_error"></span>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                </div>
                @error('email')
                <span class="text-danger error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-1">
                <label for="password" class="col-form-label">{{ __('Password') }} <span
                        class="text-danger text-bold">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" required class="form-control" placeholder="{{ __('Enter Your Password') }}">
                </div>
                @error('password')
                <span class="text-danger error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="password" class="col-form-label">{{ __('Confirm Password') }} <span
                        class="text-danger text-bold">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Retype Your Password') }}">
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-end border-purple">
            <button type="submit" class="btn bg-purple">{{ __('Reset Password') }}</button>
        </div>
    </form>
</x-guest-layout>