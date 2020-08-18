@section('input-worker')
<div class="row">
  <div class="col-m-6 input-group">
      {{Form::label('worker-name', 'Worker name: ', ['class' => 'input-label'])}}
      {{Form::text('worker-name', '', ['class' => 'input-field'])}}
  </div>
  <div class="col-m-6 input-group">
      {{Form::label('rfid', 'RFID: ', ['class' => 'input-label'])}}
      {{Form::text('rfid', '', ['class' => 'input-field'])}}
  </div>
</div>
@endsection