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
                            <td>Rating</td>
                            <td>{{$data['row']->comments_ratting}}</td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td>{{$data['row']->description}}</td>
                        </tr>
                        <tr>
                            <td>College-Name</td>
                            <td>{{$data['row']->College->name}}</td>
                        </tr>
                        <tr>
                            <td>User-Name</td>
                            <td>{{$data['row']->User->name}}</td>
                        </tr>




                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>














@endsection


