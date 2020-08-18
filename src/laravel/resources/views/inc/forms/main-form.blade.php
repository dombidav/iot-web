@section('form')
{!! Form::open(['action' => 'PlaceholderController@store', 'method' => 'POST']) !!}
  @yield('input-worker')
  @yield('input-lock')
  @yield('input-group')
  @yield('input-device')
  @yield('id-field')
{!! Form::close() !!}
@endsection