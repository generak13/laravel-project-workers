@extends('main_layout')

@section('content')
    <h1>Edit company worker</h1>

    @include('workers.partials.form_errors')

    {!! Form::model($worker, ['method' => 'PATCH', 'action' => ['WorkersController@update', $worker->id], 'class' => 'form-horizontal']) !!}
        @include('workers.partials.form')

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Save', ['id' => 'edit-worker', 'class' => 'btn btn-primary']) !!}
                <a href="{{route('workers.index')}}" class="btn btn-primary">Cancel</a>
            </div>
        </div>
    {!! Form::close() !!}
@endsection