@extends('main_layout')

@section('content')
    @if (count($workers))
        <h1>Here are a list of your company workers:</h1>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Working from</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workers as $index => $worker)
                    <tr>
                        <th scope="row">{{$workers->perPage() * ($workers->currentPage() - 1) + $index + 1}}</th>
                        <td>{{$worker->first_name}}</td>
                        <td>{{$worker->last_name}}</td>
                        <td>{{$worker->email}}</td>
                        <td>{{$worker->created_at}}</td>
                        <td>
                            <a href="{{route('workers.show', $worker->id)}}" class="show-worker btn btn-primary">View</a>
                            <a href="{{route('workers.edit', $worker->id)}}" class="edit-worker btn btn-info">Edit</a>

                            {!! Form::open(array('action' => ['WorkersController@destroy', $worker->id], 'style' => 'display: inline-block;')) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                {!! Form::submit('Delete', array('class' => 'delete-worker btn btn-warning')) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="paginator pull-right clearfix">
            {{ $workers->links() }}
        </div>
    @else
        <h1>You have not any workers in your company :(</h1>
    @endif

    <div class="actions">
        <a href="{{route('workers.create')}}" id="create-worker" class="btn btn-primary">Add worker</a>
    </div>

@endsection