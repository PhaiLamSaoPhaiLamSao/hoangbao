@extends('admin.layout')

@section('admin.content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @elseif (session('danger'))
      <div class="alert alert-danger">
          {{ session('danger') }}
      </div>
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Product Edit</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                

              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="{{  route('product.edit', [$product->id]) }}">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" value="{{ $product->name }}" name="name" class="form-control @error('name') {{ 'is-invalid' }} @enderror" id="exampleInputEmail1" placeholder="Abc">
                    
                    @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>   
                    @enderror

                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="number" value="{{ $product->price }}" name="price" class="form-control" id="exampleInputPassword1" placeholder="9">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea name="des" class="form-control @error('des') {{ 'is-invalid' }} @enderror">{{ $product->des }}</textarea>
                    @error('des')
                    <small class="text-danger">
                        {{ $message }}
                    </small>   
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Quantity</label>
                    <input type="number" value="{{ $product->qty }}" name="qty" class="form-control" id="exampleInputPassword1" placeholder="10">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Weight</label>
                    <input type="number" value="{{ $product->weight }}" name="weight" class="form-control" id="exampleInputPassword1" placeholder="10.5">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Product Category</label>
                    <select name="category_id" class="form-control">
                      <option  value="">---Please Select---</option>
                      @foreach ($productCategories as $productCategory)
                        <option {{ $product->category_id == $productCategory->id ? 'selected' : ''  }} value="{{ $productCategory->id }}">
                          {{ $productCategory->name }}
                        </option>  
                      @endforeach
                    </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection