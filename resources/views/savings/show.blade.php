@extends('app')

@section('content')


<div class="row col-md-8 col-md-offset-2">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Cuenta</th>
                  <th>Tipo de Ahorro</th>
                  <th>Total prestado</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              	<?php $i=1; ?>
              	@foreach($resultados as $value)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td><a href="/savings/{{ $value->a_id }}/edit">{{ $value->nombrecompleto }}</a></td>
                  <td>
                  
                  @if($value -> tipo == 'M')	
                  {{ "Por meta" }}
                  @else
                  {{ "Por tiempo" }}
                  @endif	
                  	
                  </td>
                  <td>{{ $value->totalprestado }}</td>
                  <td>
                  @if($value -> status == 0)	
                  {{ "Pendiente" }}
                  @else
                  {{ "Completado" }}
                  @endif
                  </td>
                 @endforeach 
                </tr>
              </tbody>
            </table>
          </div>
         <div class="row" style="text-align: center;">
         <?php echo $resultados->render(); ?>
         </div>
</div>

@endsection