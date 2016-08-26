@extends('app')
@section('content')
@foreach($element as $value)



<h2><a href="/clients/{{ $value->clieID }}/edit"> {{ $value -> nombrecompleto }} </a></h2>
<h3>
	
    @if($value -> tipo == 'M')
    		
<?php
if(substr($value -> plazo, -1) == 'm' || substr($value -> plazo, -1) == 'q' || substr($value -> plazo, -1) == 's')
{
$arregloPlazo = explode('_',$value -> plazo); 
if($arregloPlazo[1] == 'm')
echo  "Plazo de ".$arregloPlazo[0]." meses";
elseif($arregloPlazo[1] == 'q')
echo  "Plazo de ".$arregloPlazo[0]." quincenas";
elseif($arregloPlazo[1] == 's')
echo "Plazo de ".$arregloPlazo[0]." semanas";
}	
else
{
if($value -> plazo < 7)
echo "Plazo de ".$value -> plazo." quincenas";
else
echo "Plazo de ".$value -> plazo." semanas";
}
?>
		
		
	@else
		@if($value -> plazo == 7)
			{{"Plazo semanal"}}
    	@elseif($value -> plazo == 14)
			{{"Plazo quincenal"}}
		@elseif($value -> plazo == 30)
			{{"Plazo mensual"}}
		@elseif($value -> plazo == 60)
			{{"Plazo bimestral"}}
		@elseif($value -> plazo == 90)
			{{"Plazo trimestral"}}
    	@elseif($value -> plazo == 180)
			{{"Plazo semestral"}}
		@endif	
	@endif
	
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
		         {!! Form::open(['method' => 'PATCH','action' => ['SavingController@update',$element_id]]) !!}
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