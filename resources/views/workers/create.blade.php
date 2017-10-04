@extends('main_layout')

@section('content')
    <h1>Create new worker</h1>

    @include('workers.partials.form_errors')

    {!! Form::open(['action' => 'WorkersController@store', 'class' => 'form-horizontal']) !!}
        @include('workers.partials.form')

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Add', ['id' => "add-worker", 'class' => 'btn btn-primary']) !!}
                <a href="{{route('workers.index')}}" class="btn btn-primary">Cancel</a>
            </div>
        </div>
    {!! Form::close() !!}
@endsection