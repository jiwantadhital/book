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
        {!! Form::open(['route' => $route .'store' , 'method' => 'post' , 'class' => 'form-horizontal']) !!}
        @csrf

        <div class="card-body">
            <div class="form-group row">
                {!! Form::label('sem_id', 'Semester: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    {!! Form::select('sem_id', $data['sem'], null,['class' => 'form-control','placeholder' => 'Select Semester']) !!}
                    @error('sem_id')
                    <span class="text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="table-responsive">
  <table class="table table-striped table-bordered" id="image_wrapper">
    <tr>
      <th>Subject Name</th>
      <th>Action</th>
    </tr>
    <tr>
    <td><input type="text" name="chapter_title[]" class="form-control"/></td>
      <td>
        <a class="btn btn-block btn-warning sa-warning remove_row "><i class="fa fa-trash"></i></a>
      </td>
    </tr>
  </table>
  <button class="btn btn-info" type="button" id="addMoreImage"
          style="margin-bottom: 20px"> <i class="fa fa-plus"></i> Add</button>
</div>
            <!-- <div class="form-group row">
                {!! Form::label('title', 'Subject: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <br>
                <div class="col-sm-10">
                    {!! Form::text('title', '', [ 'class'=>'form-control', 'placeholder'=>'Enter Subject Name']); !!}
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
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
        + ' <td><input type="text" name="chapter_title[]" class="form-control" /></td>'
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
@endsection
