@extends('layouts.layout')

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
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus placeholder="Full Name">
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
                <a  class="btn btn-default"  href="{{ route('userManagement') }}">Cancel</a>
                <button type="submit" class="btn btn-default">Save changes</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection


@section('js')
    <script>
        $(window).on('load', function() {
            $('#modal-accountSetting').modal('show');
        });
    </script>
@endsection