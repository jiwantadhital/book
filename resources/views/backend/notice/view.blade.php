@extends('backend.layout.backend')

@section('content')
    <div class="col-sm-6 col-md-9 col-lg-9">


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$title}}
                        <a href="{{route($route .'index')}}" class="btn btn-success">List</a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>Title</td>
                            <td>{{$data['row']->title}}</td>
                        </tr>
                        <tr>
                            <td>Short-Descripton</td>
                            <td>{{$data['row']->short_description}}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! $data['row']->description!!}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>














@endsection


