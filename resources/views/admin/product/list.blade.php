@extends('admin.layout')

@section('admin.content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Product</li>
          </ol>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product</h3>
              <div class="text-right">
                <a class="btn btn-primary" href="{{ route('product.add') }}">Add</a>
              </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>STT</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Desc</th>
                  <th>Image</th>
                  <th>Qty</th>
                  <th>Weight</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($datas as $data)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->price }}</td>
                    <td>{{ $data->des }}</td>
                    <td>
                      @php
                          $image = empty($data->image) ? 'image_product_default.png' : $data->image;
                      @endphp
                      <img src="{{ asset('images')."/".$image }}" alt="{{ $image }}"
                       width="150" height="150" />
                    </td>
                    <td>{{ $data->qty }}</td>
                    <td>{{ $data->weight }}</td>
                    <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                    <td>
                      <div class="row">
                        <form action="{{ route('product.delete', [$data->id]) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <a href="{{ route('product.detail', [$data->id]) }}" class="btn btn-primary">Edit</a>
                      </div>
                    </td>
                  </tr>
                @endforeach

              
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection