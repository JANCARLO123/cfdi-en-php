@extends('app')

@section('content')


<div class="row col-md-8 col-md-offset-2">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Cuenta</th>
                  <th>Fecha del préstamo</th>
                  <th>Total prestado</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              	<?php $i=1; ?>
              	@foreach($resultados as $value)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td><a href="/loans/{{ $value->p_id }}/edit">{{ $value->nombrecompleto }}</a></td>
                  <td>{{ $value->fechaprestamo }}</td>
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
  </div>       
         <div class="row" style="text-align: center;">
         <?php echo $resultados->render(); ?>
         </div>

@endsection