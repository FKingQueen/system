@extends('layouts.layout')

@section('css')

@endsection

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="m-0">Yield Monitoring</h1>
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
              <table class="table">
                <thead>
                  <tr class="text-center">
                    <th scope="col"></th>
                    <th scope="col">Farmer</th>
                    <th scope="col">Activities</th>
                    <th scope="col">Yield</th>
                    <th scope="col">Generate</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach($data1s as $key => $data1)
                    <tr>
                      <th scope="row">{{$key+1}}</th>
                      <td>{{$data1->farmer_id}}</td>
                      <td>Farming Activity</td>
                      <td>{{$data1->yield}}</td>
                      <td>Report</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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