@extends('app')

@section('content')

<?php
$i=0;
while($i < sizeof($cuentas))
{
?>


<h2><a href="#">{{ $cuentas[$i]['nombrecompleto'] }}</a></h2>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                  <tr>
                  <th>Id</th>
                  <th>Prestado</th>
                  <th>Pagado</th>
                  <th>Saldo</th>
                  <th>Ahorro</th>
                  <th>Rendimiento</th>
                  <th>Próximo Pago</th>
                </tr>	
              </thead>
            	  <tbody>
            	  

<?php
$o=0;
$grantotalprestado = 0;
$grantotalparcialidad=0;
$grantotalsaldo = 0;
$grantotalahorro = 0;
$grantotalrendimiento = 0;
$indice = 1;
while($o < sizeof($cuentas[$i]['operacion']))
{
	
$grantotalprestado = $grantotalprestado + $cuentas[$i]['operacion'][$o]['totalprestado'];
$grantotalparcialidad = $grantotalparcialidad + $cuentas[$i]['operacion'][$o]['parcialidad'];
$grantotalsaldo = $grantotalprestado - $grantotalparcialidad ;
$grantotalahorro = $grantotalahorro + $cuentas[$i]['operacion'][$o]['ahorro'];
$grantotalrendimiento = $grantotalrendimiento + $cuentas[$i]['operacion'][$o]['rendimiento'];

	
	
?>            	  
            	  <tr>	
                  <td>{{ $indice++ }}</td>
                  <td>{{ number_format ($cuentas[$i]['operacion'][$o]['totalprestado'],2) }}</td>
                  <td>{{ number_format ($cuentas[$i]['operacion'][$o]['parcialidad'],2) }}</td>
                  <td>{{ number_format ($cuentas[$i]['operacion'][$o]['totalprestado'] - $cuentas[$i]['operacion'][$o]['parcialidad'],2) }}</td>
                  <td>{{ number_format ($cuentas[$i]['operacion'][$o]['ahorro'],2) }}</td>
                  <td>{{ number_format ($cuentas[$i]['operacion'][$o]['rendimiento'],2) }}</td>
                  <?php if($cuentas[$i]['operacion'][$o]['status'] == 1) { ?>
                  <td>Completado</td>
                  <?php }else{ ?>
                  <td>{{ $cuentas[$i]['operacion'][$o]['fechacobro'] }}</td>
                  <?php }?>	
                  </tr>
 <?php $o++; }  ?>                 
              	  <tr>	
                  <td></td>
                  <td><b>{{ number_format ($grantotalprestado,2) }}</b></td>
                  <td><b>{{ number_format ($grantotalparcialidad,2) }}</b></td>
                  <td><b>{{ number_format ($grantotalsaldo,2) }}</b></td>
                  <td><b>{{ number_format ($grantotalahorro,2) }}</b></td>
                  <td><b>{{ number_format ($grantotalrendimiento,2) }}</b></td>
                  <td></td>	
                  </tr>                
            	  	
            	  	
               	  </tbody>
            </table>
           </div>	
<?php $i++; }  ?>
@stop