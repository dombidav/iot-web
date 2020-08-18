@section('input-group')
<div class="row">
  <div class="col-m-6 input-group">
      {{Form::label('group-name', 'Group name: ', ['class' => 'input-label'])}}
      {{Form::text('group-name', '', ['class' => 'input-field'])}}
  </div>
</div>
@endsection