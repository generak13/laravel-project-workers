@if ($errors->any())
    <ul class="form-errors alert alert-danger col-sm-offset-2 col-sm-10">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif