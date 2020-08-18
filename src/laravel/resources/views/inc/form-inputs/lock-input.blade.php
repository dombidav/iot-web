@section('input-lock')
<div class="row">
  <div class="col-m-6 input-group">
      {{Form::label('lock-name', 'Lock name: ', ['class' => 'input-label'])}}
      {{Form::text('lock-name', '', ['class' => 'input-field'])}}
  </div>
  <div class="col-m-6 input-group">
      {{Form::label('lock-status', 'Status: ', ['class' => 'input-label'])}}
      {{Form::text('lock-status', '', ['class' => 'input-field'])}}
  </div>
</div>
@endsection