@extends('main_layout')

@section('content')
    <h1>Worker was retired!</h1>
    <a href="{{route('workers.index')}}" class="btn btn-primary">Back to workers list</a>
@endsection