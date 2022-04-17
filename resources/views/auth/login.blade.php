@extends('layouts.layout')

@section('content')
<div class="container-fluid p-0">
<nav class="navbar navbar-expand-md navbar-light container-fluid" style="background-color: #1d800e; height: 10%;">
</nav>
<br><br><br>
<br>

  <div class="d-flex justify-content-around mt-5 border">
    <div class="login-box border" style="width: 25rem;">

      <div class="card " >
        <div class="card-body login-card-body"  style="background-color: #E5E4D7;">
          <p class="login-box-msg">Logo of the System</p>
          <p class="login-box-msg">Brief the Description about the System</p>

        </div>
        <!-- /.login-card-body -->
      </div>
    </div>

    <!-- /.login-box -->
    <div class="login-box " style="width: 25rem;">
      <div class="card" >
        <div class="card-body login-card-body"  style="background-color: #E5E4D7;">
          <p class="login-box-msg">Sign in to start your session </p>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password"> 
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <br>
            <div class="row">
                
              <!-- <div class="col-8">
                <div class="icheck-primary mt-2">
                  <a href="{{ route('register') }}" class="text-center ml-3">Register Now</a>
                </div>
              </div> -->

              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
  </div>
</div>
@endsection

@section('js')
    <!-- SweetAlert2 -->
    <script src="https://adminlte.io/themes/v3/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/toastr/toastr.min.js"></script>

    <script>
        $(function() {
            var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: true,
            timer: 3000
            });

            //FarmerList Notifications

            @if(Session::has('loginfailed'))
                $(function() {
                    toastr.error('Your account has been deactivated')
                });
            @endif
        });
    </script>
@endsection