@extends('admin.layout')

@section('admin.content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Product Add</h3>

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
              <form role="form" method="post" action="{{  route('product.save') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') {{ 'is-invalid' }} @enderror" id="name" placeholder="Abc">
                    
                    @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>   
                    @enderror

                  </div>


                  <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" value="{{ old('slug') }}" name="slug" class="form-control @error('slug') {{ 'is-invalid' }} @enderror" id="slug" placeholder="Abc">
                    
                    @error('slug')
                    <small class="text-danger">
                        {{ $message }}
                    </small>   
                    @enderror

                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="number" name="price" class="form-control" id="exampleInputPassword1" placeholder="9">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea name="des" class="ckeditor form-control @error('des') {{ 'is-invalid' }} @enderror">{{ old('des') }}</textarea>
                    @error('des')
                    <small class="text-danger">
                        {{ $message }}
                    </small>   
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Quantity</label>
                    <input type="number" name="qty" class="form-control" id="exampleInputPassword1" placeholder="10">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Weight</label>
                    <input type="number" name="weight" class="form-control" id="exampleInputPassword1" placeholder="10.5">
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
                        <option selected value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>  
                      @endforeach
                    </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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



@section('my-script')
<script type="text/javascript">
  $(document).ready(function () {
     
      $('#name').keyup(function(){
        var title = $("#name").val(); 
        // console.log(title);
        $.ajax({
            type: 'POST', //method of form
            url : "{{ route('product.get_slug') }}", // action of from
            data: { title: title, _token: "{{ csrf_token() }}" }, // data of form 
            success: function(data){
                // console.log(data);
                $('#slug').val(data.slug);
            },
        });
      });
      
    $('.ckeditor').ckeditor();
  });
</script>
@endsection