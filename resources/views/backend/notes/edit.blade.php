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
                    {!! Form::label('sem_id', 'Semester: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <div class="col-sm-10">
                        {!! Form::select('sem_id', $data['sem'], null,['class' => 'form-control','placeholder' => 'Select Category', 'id'=>'semester',]) !!}
                        @error('sem_id')
                        <span class="text text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('sub_id', 'Subject: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <div class="col-sm-10">
                        <select class="form-control  formselect required"  placeholder="Select Subject" name="sub_id" id="subject">
                            <option value="{{$data['row']->sub_id}}">{{$data['row']->Subject->title}}</option>
                        </select>
                        @error('sub_id')
                        <span class="text text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('chapter_id', 'Chapter: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <div class="col-sm-10">
                        <select class="form-control  formselect required"  placeholder="Select Subject" name="chapter_id" id="chapter">
                            <option value="{{$data['row']->chapter_id}}">{{$data['row']->Chapter->name}}</option>
                        </select>
                        @error('chapter_id')
                        <span class="text text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('notes','Notes: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('notes', null, [ 'class'=>'ckeditor form-control', 'placeholder'=>'Enter Description','id'=>'summernotes',]); !!}
                        @error('notes')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>

                </div>





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
                $('#subject').empty();
                $('#subject').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'get',
                    url: 'getSubCategoriesedt/' +ids,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#subject').empty();
                        $('#subject').append(`<option value="0" disabled selected>Select Subject*</option>`);
                        response.forEach(element => {
                            $('#subject').append(`<option value="${element['id']}">${element['title']}</option>`);
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#subject').on('change', function () {
                let idss = $(this).val();
                $('#chapter').empty();
                $('#chapter').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'get',
                    url: 'getchapteredt/' +idss,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#chapter').empty();
                        $('#chapter').append(`<option value="0" disabled selected>Select Chapter*</option>`);
                        response.forEach(element => {
                            $('#chapter').append(`<option value="${element['id']}">${element['name']}</option>`);
                        });
                    }
                });
            });
        });
    </script>


@endsection


