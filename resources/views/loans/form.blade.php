<div class="form-group">
{!! Form::label('idcliente','¿A quién le prestarás?') !!}
{!! Form::select('idcliente',$data,null,['class' => 'form-control','onchange' => 'agregarLimite();','id' => 'cuenta']) !!}
</div>
<div class="form-group">
<label>Límite de Crédito = </label>	
<b id="limiteCredito" name="limiteCredito">50000.00</b>
</div>
<div class="form-group">
{!! Form::label('monto','Monto que quieres prestar') !!}
{!! Form::text('monto','0.00',['class' => 'form-control',
                               'placeholder' => 'Recomendamos que no sea mayor que el límite de crédito',
                               'onkeyup' => 'calcularRendimiento(); calcularAhorro(); recalcularParcialidades();',
                               'onfocusin' => 'limpiarMonto();']) !!}
</div>


<div class="form-group">
{!! Form::label('porcentajeRendimiento','Rendimiento que quieres recibir sobre el préstamo ') !!}
{!! Form::select('porcentajeRendimiento',['0' => '0%','0.05' => '5%','0.1' => '10%'],
                          null,['class' => 'form-control','onchange' => 'calcularRendimiento();']) !!}
</div>

<div class="form-group">
Rendimiento Generado con el Préstamo <span><b id="rendimientoTotal">0.00</b></span>
{!! Form::hidden('rendimiento',0.00,['class' => 'form-control','id' => 'rendimiento']) !!}	
</div>

<div class="form-group">
{!! Form::label('porcentajeAhorro','Porcentaje de Ahorro que quieres que genere este préstamo ') !!}
{!! Form::select('porcentajeAhorro',['0' => '0%','0.05' => '5%','0.1' => '10%'],
                          null,['class' => 'form-control','onchange' => 'calcularAhorro();']) !!}
</div>



<div class="form-group">
Ahorro Generado con el Préstamo <span><b id="ahorroTotal">0.00</b></span>
{!! Form::hidden('ahorro',0.00,['class' => 'form-control','id' => 'ahorro']) !!}	
</div>


<div class="form-group">
Pagos: <span><b id="parcialidad">0.00</b></span>
{!! Form::hidden('parcialidad2',0.00,['class' => 'form-control','id' => 'parcialidad2']) !!}	
</div>	


<div class="form-group">
{!! Form::label('plazo','Plazo y Frecuencia de pagos') !!}
{!! Form::select('plazo',['1_m' => '1 Mes','2_m' => '2 Meses','3_m' => '3 Meses',
                          '4_m' => '4 Meses','5_m' => '5 Meses','6_m' => '6 Meses',
                          '4_q' => '4 Quincenas','5_q' => '5 Quincenas','6_q' => '6 Quincenas',
                          '7_q' => '7 Quincenas','8_q' => '8 Quincenas','9_q' => '9 Quincenas',
                          '10_q' => '10 Quincenas','11_q' => '11 Quincenas','12_q' => '12 Quincenas',
                          '8_s' => '8 Semanas','10_s' => '10 Semanas','12_s' => '12 Semanas',
                          '14_s' => '14 Semanas','16_s' => '16 Semanas','18_s' => '18 Semanas',
                          '20_s' => '20 Semanas','22_s' => '22 Semanas','24_s' => '24 Semanas' ],
                          null,['class' => 'form-control','onchange' => 'recalcularParcialidades();']) !!}
</div>

<div class="form-group">
{!! Form::label('fechaprestamo','Selecciona el día en que harás el desembolso') !!}
{!! Form::text('fechaprestamo',null,['class' => 'datepicker form-control','readonly' => 'readonly']) !!}
</div>

<div class="form-group">
{!! Form::label('fechaprimerpago','Selecciona el día en que quieres que se te haga el primer pago') !!}
{!! Form::text('fechaprimerpago',null,['class' => 'datepicker form-control','readonly' => 'readonly',
               'onchange' => 'calcularParcialidades();']) !!}
</div>

<!-- Detalles -->
	<div style="width: 100%; padding-top: 20px; display: none;" class="form-group" id="act1">
	</div>
<!-- Detalles -->
   	
<!-- Detalles Móvil -->
	
	<div style="width: 100%; display: none;" class="form-group" id="actm1">
	</div>
<!-- Detalles Móvil-->



<div class="form-group">
Total a Prestar	<span><b id="totalPrestadoB">0.00</b></span>
{!! Form::hidden('totalprestado',0.00,['class' => 'form-control','id' => 'totalprestado']) !!}
</div>

<div class="form-group">
{!! Form::submit($SubmitButtonText,['class' => 'btn btn-primary form-control']) !!}
</div>