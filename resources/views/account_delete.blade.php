<!DOCTYPE html>
<html lang="en">
@include('backend.includes.head')

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-sm-6 col-md-9 col-lg-9">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">"Account Delete"
                            </h3>
                        </div>
        <!-- /.card-header -->
        <!-- form start -->
        {!! Form::open(['route' => 'store' , 'method' => 'post' , 'class' => 'form-horizontal']) !!}
        @csrf

        <div class="card-body">
            <div class="form-group row">
                {!! Form::label('email', 'Name: <span class="required">*</span>',['class' => 'col-form-label'],false); !!}
                <br>
                <div class="col-sm-10">
                    {!! Form::text('email', '', [ 'class'=>'form-control', 'placeholder'=>'Enter name']); !!}
                    @error('email')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('desc', 'Description: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <br>
                <div class="col-sm-10">
                    {!! Form::textarea('desc', '', [ 'class'=>'form-control', 'placeholder'=>'Enter Description','id'=>'desc',]); !!}
                    @error('desc')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
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



        <!-- Main content -->

       @yield('content')

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('backend.includes.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

@include('backend.includes.script')
</body>
</html>