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
                    {!! Form::label('title', 'Title: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <br>
                    <div class="col-sm-10">
                        {!! Form::text('title', null, [ 'class'=>'form-control', 'placeholder'=>'Enter name']); !!}
                        @error('title')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    {!! Form::label('short_description', 'Short-Description: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                    <br>
                    <div class="col-sm-10">
                        {!! Form::textarea('short_description', null, [ 'class'=>'form-control', 'placeholder'=>'Enter Description','id'=>'summernotes',]); !!}
                        @error('short_description')
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


