@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0">Crop Monitoring</h1>
          </div>
          <!-- /.col -->
      </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

              <form action="{{ route('cropMonitoring') }}" method="GET">
                @csrf
                <div class="d-flex justify-content-between">
                  <div class="d-flex justify-content-left mb-3">
                    <div>
                      <label for="municipality_id" class="input-group">Municipality</label>
                      <select id="municipality_id" type="text" name="municipality_id" class="custom-select form-control-border @error('municipality_id') is-invalid @enderror" name="municipality_id" required autocomplete="municipality_id" autofocus>
                          <option disabled selected>--- Select Municipality ---</option>
                          <option value="1">Badoc</option>
                          <option value="2">Banna</option>
                          <option value="3">Batac City</option>
                          <option value="4">Currimao</option>
                          <option value="5">Dingras</option>
                          <option value="6">Marcos</option>
                          <option value="7">Nueva Era</option>
                          <option value="8">Paoay</option>
                          <option value="9">Pinili</option>
                          <option value="10">San Nicolas</option>
                          <option value="11">Solsona</option>
                      </select>
                        @error('municipality_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror          
                    </div>

                    <div class="ml-3">
                      <label for="year_id" class="input-group">Year</label>
                      <select id="year_id" type="text" name="year_id" class="custom-select form-control-border @error('year_id') is-invalid @enderror" name="year_id" required autocomplete="year_id" autofocus>
                          <option disabled selected>--- Select  Year ---</option>
                      </select>
                        @error('year_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror          
                    </div>
                    <div class="ml-3 d-flex align-items-end">
                      <button type="submit" class="btn btn-block btn-primary input-group"> FIND </button>
                    </div>
                  </div>
                </div>
              </form>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div class="input-group  d-flex justify-content-center">
              <h3 class="text-center">FARMING ACTIVITIES</h3>
            </div>

            <div class="input-group">
              <table class="table table-hover text-center">
                <thead>
                  <tr>
                    <th scope="col">Farmer</th>
                    <th scope="col">Water</th>
                    <th scope="col">Fertilizer</th>
                    <th scope="col">Pesticide</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($farmers as $farmer)
                    <tr>
                        <th scope="row"> <a type="button">{{$farmer->name}}</a></th>
                        @foreach($pwaters as $pwater)
                        <td>{{$pwater}}</td>
                        @endforeach
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>



@endsection

@section('js')

@endsection