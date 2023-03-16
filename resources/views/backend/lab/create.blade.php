@extends('backend.layout.backend')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-sm-6 col-md-9 col-lg-9">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{$title}} Forms
                                <a href="{{route($route .'index')}}" class="btn btn-success">Lists</a>
                            </h3>
                        </div>
        <!-- /.card-header -->
        <!-- form start -->
        {!! Form::open(['route' => $route .'store' , 'method' => 'post' , 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
        @csrf

        <div class="card-body">
            <div class="form-group row">
                {!! Form::label('sem_id', 'Semester: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    {!! Form::select('sem_id', $data['sem'], null,['class' => 'form-control','placeholder' => 'Select Semester','id'=>'semester',]) !!}
                    @error('sem_id')
                    <span class="text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                {!! Form::label('sub_id', 'Subject: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    <select class="form-control  formselect required"  placeholder="Select Sub Category" name="sub_id" id="subject"></select>
                    @error('sub_id')
                    <span class="text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>

            <div class="table-responsive">
  <table class="table table-striped table-bordered" id="image_wrapper">
    <tr>
      <th>Image</th>
      <th>Action</th>
    </tr>
    <tr>
      <td><input type="file" name="product_image[]" class="form-control"/></td>
      <td>
        <a class="btn btn-block btn-warning sa-warning remove_row "><i class="fa fa-trash"></i></a>
      </td>
    </tr>
  </table>
  <button class="btn btn-info" type="button" id="addMoreImage"
          style="margin-bottom: 20px"> <i class="fa fa-plus"></i> Add</button>
</div>
            <!-- <div class="form-group row">
                {!! Form::label('image','Image: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    {!! Form::file('image', [ 'class'=>'form-control','id'=>'image_file','name'=>'image_file']); !!}
                    @error('image')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                @error('updated_by')
                <p> error</p>
                @enderror
            </div> -->




        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" >Submit</button>
        </div>

    </div>
</div>






            </div>
            <!-- /.card -->
        </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('csss')

    <script>
        $(document).ready(function () {
            $('#semester').on('change', function () {
                let id = $(this).val();
                $('#subject').empty();
                $('#subject').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: 'getSubCategories/' +id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#subject').empty();
                        $('#subject').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                        response.forEach(element => {
                            $('#subject').append(`<option value="${element['id']}">${element['title']}</option>`);
                        });
                    }
                });
            });
        });
    </script>
</script>
    <style>
        .required{
            color: red;
        }
    </style>
@endsection
@section('jss')
<script>
     var y = 1;
  var image_wrapper = $("#image_wrapper"); //Fields wrapper
  var add_button_image = $("#addMoreImage"); //Add button ID
  $(add_button_image).click(function (e) { //on add input button click
    var max_fields = 15; //maximum input boxes allowed
    e.preventDefault();
    if (y < max_fields) { //max input box allowed
      y++; //text box increment
      var id = 'remove_row' + y;
      $("#image_wrapper tr:last").after(
        '<tr>'
        + ' <td><input type="file" name="product_image[]" class="form-control" /></td>'
        + '<td>'
        + '<a class="btn btn-block btn-warning sa-warning remove_row"> <i class="fa fa-trash"></i></a>'
        + '</td>'
        + '</tr>');

    } else {
      alert("Max field reached. " + max_fields + " allowed");
    }
  });

  $(image_wrapper).on("click", ".remove_row", function (e) {
    e.preventDefault();
    $(this).parents("tr").remove();
    y--;
  });
    </script>
    <script>
        $(document).ready(function () {
            $('#semester').on('change', function () {
                let id = $(this).val();
                $('#subject').empty();
                $('#subject').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: 'getSubCategories/' +id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#subject').empty();
                        $('#subject').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                        response.forEach(element => {
                            $('#subject').append(`<option value="${element['id']}">${element['title']}</option>`);
                        });
                    }
                });
            });
        });
    </script>


@endsection
