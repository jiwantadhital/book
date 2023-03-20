@extends('backend.layout.backend')

@section('content')
    <div class="col-sm-6 col-md-9 col-lg-9">
        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">{{$title}}-Form
                    <a href="{{route($route .'index')}}" class="btn btn-success">List</a>
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($data['row'], ['route' => [$route.'update', $data['row']->id ]]) !!}
            {!! Form::hidden('_method', 'PUT') !!}
            @csrf

            <div class="card-body">
                <div class="form-group row">
                    {!! Form::label('name', 'Name: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <br>
                    <div class="col-sm-10">
                        {!! Form::text('name',null, [ 'class'=>'form-control', 'placeholder'=>'Enter name']); !!}
                        @error('name')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('description', 'Description: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <br>
                    <div class="col-sm-10">
                        {!! Form::textarea('description', null, [ 'class'=>'ckeditor form-control', 'placeholder'=>'Enter Description','id'=>'summernotes',]); !!}
                        @error('description')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('details', 'Details: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <br>
                    <div class="col-sm-10">
                        {!! Form::textarea('details', null, [ 'class'=>'ckeditor form-control', 'placeholder'=>'Enter Details','id'=>'summernotes',]); !!}
                        @error('details')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
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
                </div>
{{--                <div class="form-group row">--}}
{{--                    <lable><strong>Old-Image</strong></lable>--}}
{{--                    <div class="col-sm-10">--}}
{{--                        <img src="{{asset('uploads/images/collegequestion/'.$data['row']->image)}}" class=" col-form-label" alt=""--}}
{{--                             style="height: 250px; width: 250px; border-left:   75px solid white ; ">--}}
{{--                    </div>--}}
{{--                </div>--}}




            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
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
        $(document).ready(function () {
            $('#semester').on('change', function () {
                let ids = $(this).val();
                // $('#subject').empty();
                // $('#subject').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'get',
                    url: 'getSubCategoriesedt/' +ids,
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


