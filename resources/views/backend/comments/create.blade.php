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
                {!! Form::label('comments_ratting', 'Comment Rating: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <br>
                <div class="col-sm-10">
                    {!! Form::number('comments_ratting', '', [ 'class'=>'form-control', 'placeholder'=>'Enter name','min' => '1','max'=>'5']); !!}
                    @error('comments_ratting')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('description', 'Description: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <br>
                <div class="col-sm-10">
                    {!! Form::textarea('description', '', [ 'class'=>'ckeditor form-control', 'placeholder'=>'Enter Description','id'=>'summernotes',]); !!}
                    @error('description')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('college_id', 'College: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    {!! Form::select('college_id', $data['college'], null,['class' => 'form-control','placeholder' => 'Select Semester','id'=>'semester',]) !!}
                    @error('college_id')
                    <span class="text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
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



@endsection
