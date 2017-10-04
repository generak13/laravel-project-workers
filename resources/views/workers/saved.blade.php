@extends('main_layout')

@section('content')
    <h1>Worker has been saved successfully</h1>

    <h3>Details:</h3>

    @include('workers.partials.workers_details')

    <a href="{{route('workers.index')}}" class="btn btn-primary">Back to workers list</a>
@endsection