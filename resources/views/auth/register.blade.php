@extends('layouts.layout')

@section('content')
<div class="container-fluid p-0">
<nav class="navbar navbar-expand-md navbar-light container-fluid" style="background-color: #1d800e; height: 10%;">
</nav>
<br>

  <div class="d-flex justify-content-center">
    <div class="register-box" style="width: 25rem;">

      <div class="register-logo">
        <img src="{{ asset('images/Logo1.png')}}" width="60%" height="60%" alt="Image" >
      </div>

      <div class="card" >
        <div class="card-body register-card-body" style="background-color: #E5E4D7;">
          <p class="login-box-msg">Register</p>
          <!-- {{ route('register') }} -->
          <form method="POST" action="{{ route('registration') }}" enctype="multipart/form-data">
            @csrf

            <div class="input-group mb-3">
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror          
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            
            
            <div class="input-group mb-3">
                  <select id="muni_address" type="number" class="form-control @error('muni_address') is-invalid @enderror" name="muni_address" required autocomplete="muni_address" autofocus>
                      <option disabled selected>Municipal Department Office</option>
                      <option value="Badoc" >Badoc</option>
                      <option value="Banna" >Banna</option>
                      <option value="Batac City" >Batac City</option>
                      <option value="Currimao" >Currimao</option>
                      <option value="Dingras" >Dingras</option>
                      <option value="Marcos" >Marcos</option>
                      <option value="Nueva Era" >Nueva Era</option>
                      <option value="Paoay" >Paoay</option>
                      <option value="Pinili" >Pinili</option>
                      <option value="San Nicolas" >San Nicolas</option>
                      <option value="Solsona" >Solsona</option>
                  </select>

                  @error('unit_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-building"></span>
                    </div>
                  </div>
            </div>  

            <div class="input-group mb-3">
              <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
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
              <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
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

            <div class="input-group mb-3">
              <input id="password_confirmation" type="text" class="form-control" name="password_confirmation"  required autocomplete="new-password" placeholder="Retype Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="input-group">
              <label for="id_confirm">Insert ID Picture:</label>
            </div>
            <div class="input-group mb-3">  
              <input id="id_confirm" type="file" class="form-control @error('id_confirm') is-invalid @enderror" name="id_confirm" required autocomplete="id_confirm">
                @error('id_confirm')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-portrait"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <label for="agreeTerms">
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <a href="{{ route('login') }}" class="text-center">I want to Login</a>
        </div>
        <!-- /.form-box -->
      </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
  </div>
@endsection