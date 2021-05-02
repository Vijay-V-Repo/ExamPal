@extends('layouts.main')
@section('title', 'Login')
@section('content')
    <div class="container mt-5">
        <div class="login py-5" style="max-width: 800px;border: 3px solid #0c8b51;">
            <div class="main-part" style="max-width: 500px">
                <div class="method-account">
                    <h2 class="login" style="padding: 40px">Login</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6 px-0">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6 px-0">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center offset-2">
                            <button type="submit" class="btn btn-success px-5 py-1 mb-2" style="min-width: 250px;background: #0c8b51 !important;font-size: 22px;line-height: 38px;font-weight: 700; border: #ff5421 3px solid">Login</button><br>
                            <p class="mt-2">Not registered? <a href="{{ route('register') }}" class="btn btn-link pl-1" style="color: #ff5421">Create an account</a><br></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection