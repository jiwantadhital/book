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
            <div class="form-group row">
                {!! Form::label('title', 'Subject: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <br>
                <div class="col-sm-10">
                    {!! Form::text('title', '', [ 'class'=>'form-control', 'placeholder'=>'Enter Subject Name']); !!}
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
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
