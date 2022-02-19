@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Account Setting</h1>
        </div>
        <!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- .modal -->
<div class="modal fade" id="modal-accountSetting">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Account Setting</h4>
        </div>

        <form method="POST" action="{{ route('updateAccount',Auth::user()->id) }}">
            @csrf
            <div class="modal-body">
                
            <!-- Update Name -->
            <div class="input-group mb-3">
                <label for="name" class="input-group">Name:</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" value="{{Auth::user()->name}}">
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
            <!-- /Update Name -->

            <!-- Update Email -->
            <div class="input-group mb-3">
                <label for="email" class="input-group">Email:</label>
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" value="{{Auth::user()->email}}">
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
            <!-- /Update Email -->

            <!-- Update Municipality Address -->
            <div class="input-group mb-3">
                <label for="muni_address" class="input-group">Municipality Address:</label>
                <select id="muni_address" type="number" class="form-control @error('muni_address') is-invalid @enderror" name="muni_address" required autocomplete="muni_address" autofocus>
                    <option disable selected>{{Auth::user()->muni_address}}</option>
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
                @error('muni_address')
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
            <!-- /Update Municipality Address -->

            <!-- Change Password -->
            <div class="input-group mb-3">
                <label for="password" class="input-group">Password:</label>
                <button type="Button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#changepass_user">
                Change Password
                </button>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <!-- /Change Password -->

            </div>
            <div class="modal-footer justify-content-between">
                <a  class="btn btn-default"  href="{{ route('home') }}">Close</a>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Change Password Modal -->
<div class="modal fade" id="changepass_user">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title">Changing Password</h4>
    </div>

    <form method="POST" action="{{ route('updatePassword',Auth::user()->id) }}">
    @csrf
    <div class="modal-body">


        <!-- Update Password -->
        <div class="input-group mb-3">
            <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">
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
        <!-- /Update Password -->
        <!-- Update Retype Password -->
        <div class="input-group mb-3">
            <input id="password_confirmation" type="text" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"  required autocomplete="new-password" placeholder="Retype New Password">
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
        <!-- /Update Retype Password -->
    </div>

    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modal-accountSetting">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
    </form>
</div>
</div>
</div>
<!-- /Change Password Modal -->
@endsection


@section('js')
    <script>
        $(window).on('load', function() {
            $('#modal-accountSetting').modal('show');
        });
    </script>
@endsection