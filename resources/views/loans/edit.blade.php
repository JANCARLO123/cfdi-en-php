@extends('app')
@section('content')
@foreach($element as $value)

<h2><a href="/clients/{{ $value->clieID }}/edit"> {{ $value -> nombrecompleto }} </a></h2>
<h3>

<?php
if(substr($value -> plazo, -1) == 'm' || substr($value -> plazo, -1) == 'q' || substr($value -> plazo, -1) == 's')
{
$mplazo = "";
$arregloPlazo = explode('_',$value -> plazo); 
if($arregloPlazo[1] == 'm')
echo $mplazo = $arregloPlazo[0]." meses";
elseif($arregloPlazo[1] == 'q')
echo $mplazo = $arregloPlazo[0]." quincenas";
elseif($arregloPlazo[1] == 's')
$mplazo = $arregloPlazo[0]." semanas";
}	
else
{
if($value -> plazo < 7)
echo $value -> plazo." quincenas";
else
echo $value -> plazo." semanas";
}
?>





</h3>
 <hr class="featurette-divider">

        <h2 class="sub-header">Tus próximos pagos</h2>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                  <tr>
                  <th>Pago</th>
                  <th>Fecha</th>
                  <th>Cobro</th>
                  <th>Status</th>
                  <th>Abonar</th>
                </tr>	
              </thead>
              <tbody>
              <?php $i = 1; $suma = 0;?>	
              @foreach($element_item as $value_item)
              <?php $suma = $suma + $value_item -> abonado; ?>	
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td>{{ $value_item ->fechacobro }}</td>
                  <td>{{ $value_item ->parcialidad }}</td>          
                  <td>
                  	<span style="color:
                  	@if($value_item -> abonado == $value_item ->parcialidad)
                  	{{ "green" }}
                  	@elseif($value_item -> abonado > 0)
                  	{{"black"}}
                  	@else
                  	{{"red"}}
                  	@endif
                  	">
                  	
                  	@if($value_item -> abonado == $value_item ->parcialidad)
                  	{{ "Pagado" }}
                  	@elseif($value_item -> abonado > 0)
                  	{{ $value_item ->abonado }}
                  	@else
                  	{{"Pendiente"}}
                  	@endif
                  	
                  	
                  	</span>	
                  	</td>
                  <td><a style="cursor: pointer;" onclick="abonar({{ $value_item ->id }});">Abonar</a>
                 <br />
                 <div id="act{{ $value_item ->id }}" style="display: none; text-align: right; width: 50px;">                 	
		         {!! Form::open(['method' => 'PATCH','action' => ['LoanController@update',$element_id]]) !!}
		         {!! Form::text('parc',$value_item ->parcialidad,['class' => 'form-control','style' => 'width:60px;']) !!}
		         {!! Form::hidden('id',$value_item ->id,['class' => 'form-control']) !!}	
		         {!! Form::hidden('ven',$element_id,['class' => 'form-control']) !!}
		         {!! Form::hidden('compara',$value_item ->parcialidad,['class' => 'form-control']) !!}
		         <br />
		         {!! Form::submit('Abonar',['class' => 'btn btn-primary']) !!}
		         {!! Form::close() !!}
		</div>	
                  	
                  </td>
                </tr>
              @endforeach   
              </tbody>
            </table>
           </div>


 <hr class="featurette-divider">

        <h2 class="sub-header">Resumen</h2>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                  <tr>
                  <th></th>
                  <th>Egresos</th>
                  <th>Ingresos</th>
                </tr>	
              </thead>
              <tbody>
                <tr>
                <td><b>Rendimiento</b></td>
                <td>{{ $value -> rendimiento }}</td>	
                <td></td>
                </tr>
                <tr>
                <td><b>Ahorro</b></td>
                <td>{{ $value -> ahorro }}</td>	
                <td></td>
                </tr>
                <tr>
                <td><b>Préstamo</b></td>
                <td>{{ number_format ($value -> totalprestado - $value -> ahorro - $value -> rendimiento,2) }}</td>	
                <td></td>
                </tr>
                <tr>
                <td><b>Saldos</b></td>
                <td><b>{{ $value -> totalprestado }}</b></td>	
                <td><b>{{ number_format ($suma,2) }}</b></td>
                </tr>			                
              </tbody>
            </table>
           </div>

@endforeach





<script type="text/javascript">



function abonar(id)
{
nombre = 'act'+id;		
if(document.getElementById(nombre).style.display=="none")	
{
document.getElementById(nombre).style.display = "inline-block";
}else
{
document.getElementById(nombre).style.display = "none";	
}	
}


</script>
@stop	