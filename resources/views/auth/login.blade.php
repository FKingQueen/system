@extends('layouts.layout')

@section('content')
<div class="container-fluid p-0">
<nav class="navbar navbar-expand-md navbar-light mb-4 container-fluid" style="background-color: #1d800e;">
<div class="container-fluid mb-4">
  <a class="text-white"><b>Script Farm Logo</b></a>
</div>
</nav>
<br><br>
  <div class="d-flex justify-content-center mt-4">
    
    <div class="login-box" style="width: 30rem;">
      <!-- /.login-logo -->
      <div class="register-logo">
        <a><b>Script Farm</b></a>
      </div>

      <div class="card">
        <div class="card-body login-card-body"  style="background-color: #E5E4D7;">
          <p class="login-box-msg">Sign in to start your session</p>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <br>
            <div class="input-group mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password"> 
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>

              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p>
          <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center">Register Now</a>
          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
  </div>
</div>
@endsection