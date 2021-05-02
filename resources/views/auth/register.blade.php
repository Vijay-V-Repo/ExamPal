@extends('layouts.main')
@section('title', 'Register')
@section('content')
    <div class="container mb-5 mt-5">
        <div class="login py-1" style="max-width: 800px;border: 3px solid #0c8b51;">
            <div class="main-part" style="max-width: 500px">
                <div class="method-account">
                    <h2 class="login" style="padding: 40px">Register</h2>
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6 px-0">
                                <input id="name" type="text" class="form-control mb-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6 px-0">
                                <input id="email" type="email" class="form-control mb-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right mr-2">{{ __('I\'m a') }}</label>

                            <div class="col-md-6 px-0 mt-1">
                                <select id="role" class="form-control custom-select mb-2 @error('role') is-invalid @enderror" name="role" required>
                                    <option value="student" @if(old('role') === 'student') selected @endif>Student</option>
                                    <option value="teacher" @if(old('role') === 'teacher') selected @endif>Teacher</option>
                                </select>

                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>

                            <div class="col-md-6 px-0 custom-control">
                                <input id="avatar" type="file" class="custom-file mb-2 @error('avatar') is-invalid @enderror" name="avatar" value="{{ old('avatar') }}" required>

                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6 px-0">
                                <input id="password" type="password" class="form-control mb-2 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6 px-0">
                                <input id="password_confirmation" type="password" class="form-control mb-2 @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center offset-2">
                            <button type="submit" class="btn btn-success px-5 py-1 mb-2" style="min-width: 270px;background: #0c8b51 !important;font-size: 22px;line-height: 38px;font-weight: 700; border: #ff5421 3px solid">Register</button><br>
                            <p class="mt-2">Already registered? <a href="{{ route('login') }}" class="btn btn-link pl-1">Click here to login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection