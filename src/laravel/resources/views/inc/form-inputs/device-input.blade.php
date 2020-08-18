@extends('inc.forms.main-form')

@section('input-device')
<div class="row">
  <div class="col-m-6 input-group">
      {{Form::label('device-name', 'Device name: ', ['class' => 'input-label'])}}
      {{Form::text('device-name', '', ['class' => 'input-field'])}}
  </div>
  <div class="col-m-6 input-group">
      {{Form::label('device-category', 'Category: ', ['class' => 'input-label'])}}
      {{Form::text('device-category', '', ['class' => 'input-field'])}}
  </div>
</div>

<div class="row">
  {{Form::submit('Submit', ['class' => 'btn btn-main btn-input'])}}
</div>
@endsection

@section('id-field')
  <div class="id-field">
    <p><small>Device ID: </small></p>
    <p><small>lock ID: </small></p>
  </div>
@endsection