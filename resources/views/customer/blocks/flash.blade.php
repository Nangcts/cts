@if(count($errors)>0)
@foreach($errors->all() as $error)
<p class="alert alert-danger">{{$error}}</p>
@endforeach
@endif
@if(Session::has('error'))
<p class="alert alert-danger">{{Session::get('error')}}</p>
@endif
@if(Session::has('success'))
<p class="alert alert-success">{{Session::get('success')}}</p>
@endif