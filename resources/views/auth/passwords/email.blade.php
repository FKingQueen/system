@extends('layouts.layout')

@section('content')
<div class="container-fluid p-0">
  <nav class="navbar navbar-expand-md navbar-light container-fluid" style="background-color: #1d800e; height: 13%;">
    <div class="container">
        <a href="{{ route('logout') }}">
            <img src="{{ asset('images/logo.png')}}" width="10%" height="10%" alt="Image" >
        </a>
    </div>
  </nav>
<br><br><br>

  <div class="h-100 d-flex justify-content-center">

  <div class="container align-self-center borderm">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
      
  </div>
</div>


@endsection
