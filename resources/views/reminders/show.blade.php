@extends('app')

@section('content')

<div class="row">
<div class="col-md-4"><h3>Tus avisos</h3></div>

</div>

<br />


          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th>Cliente</th>	
                  <th>Fecha de Inicio</th>
                  <th>Próximo Aviso</th>
                  <th>Fecha Final</th>
                  <th>Cancelar</th>    
                </tr>
              </thead>
              <tbody>
              	<?php $i=1; ?>
              	@foreach($resultados as $value)
                <tr>
                @if( $value->tipo  == '1')	
                  <td>Cobro</td>
                @elseif( $value->tipo  == '2')
                  <td>Cumpleaños</td>
                @elseif( $value->tipo  == '3')
                  <td>Voz</td>
                @elseif( $value->tipo  == '4')
                  <td>Abierto</td>
                @endif  
                  <td><a href="/reminders/{{ $value->id }}/edit">{{ $value->nombrecompleto }}</a></td>
                  <td>{{ $value->fechainicio }}</td>
                  <td>{{ $value->fechaactual }}</td>
                  <td>{{ $value->fechafinal }}</td>
                  @if($value->status == '0')
                  <td><a href="/reminders/{{ $value->id }}/cancel">Cancelar</a></td>
                  @elseif($value->status == '1')
                  <td><b>Cancelado</b></td>
                  @elseif($value->status == '2')
                  <td><b>Completado</b></td>
                  @endif                 
                 @endforeach 
                </tr>
              </tbody>
            </table>
          </div>

         <div class="row" style="text-align: center;">
         <?php echo $resultados->render(); ?>
         </div>

@stop

@section('js')

<script type="text/javascript">

var subtotal = 0;
var iva = 0;
var total = 0;

$(document).ready(function(){
	
	 subtotal = $('#pedido').val() * 2;
      $('#c_subtotal').text(subtotal.toFixed(2));
       iva = subtotal * 0.16;
      $('#c_iva').text(iva.toFixed(2));
       total = subtotal + iva;
      $('#c_total').text(total.toFixed(2));     
	
  $('#pedido').change(function(){   
  	  subtotal = $('#pedido').val() * 2;
      $('#c_subtotal').text(subtotal.toFixed(2));
       iva = subtotal * 0.16;
      $('#c_iva').text(iva.toFixed(2));
       total = subtotal + iva;
      $('#c_total').text(total.toFixed(2));     
  });
  });
  
 function mostrarForma()
 {
 if(document.getElementById('comprarFolios').style.display == 'none')	
 document.getElementById('comprarFolios').style.display = 'inline';
 else
 document.getElementById('comprarFolios').style.display = 'none';
 return true;	
 }
   
</script>  
@stop