<x-guest-layout title="{{ __('Register') }}">

    <div class="card-header py-2 border-purple">
        <h4 style="font-family: 'Poppins', cursive; font-weight: 700 !important;">{{ __('Register') }}</h4>
        <div class="text-danger text-sm text-bold">
            {{ __('* required fileds') }}
        </div>
    </div>
    <form class="form-horizontal" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="card-body ">
            @if(session()->has('status'))
            <div class="card p-1 text-danger bg-transparent border">
                <span><i class="fas fa-info-circle"></i> <strong>{{ session('status') }}</strong></span>
            </div>
            @endif
            <div class="form-group mb-1">
                <label for="name" class="col-form-label">{{ __('Name') }} <span
                        class="text-danger text-bold">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{ __('Enter Your Full Name') }}" name="name"
                        value="{{ old('name') }}" required autofocus>
                </div>
                @error('name')
                <span class="text-danger error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-1">
                <label for="email" class="col-form-label">{{ __('Email') }} <span
                        class="text-danger text-bold">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                        placeholder="{{ __('Enter Your Email') }}" required>
                </div>
                @error('email')
                <span class="text-danger error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-1">
                <label for="id_position" class="col-form-label">{{ __('User Position') }} <span class="text-danger text-bold">*</span></label>
                <div class="input-group">
                    <div class="row m-0 p-0 w-100">
                        <div class="d-flex flex-row w-100">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                            </div>
                            <select class="form-control select2" style="width: 100%" name="id_position">
                                <option selected="selected" disabled>{{ __('Select User Position') }}</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('id_position') ? "selected='selected'" : ''  }}>{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @error('id_position')
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
                    <input type="password" name="password" required autocomplete="new-password" class="form-control"
                        placeholder="{{ __('Enter Your Password') }}">
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
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="{{ __('Retype Your Password') }}">
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between border-purple">
            <a href="{{ route('login') }}" class="btn btn-default">{{ __('Login') }}</a>
            <button type="submit" class="btn bg-purple">{{ __('Register') }}</button>
        </div>
    </form>
</x-guest-layout>
