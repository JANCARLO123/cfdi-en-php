<div class="form-group">
{!! Form::label('cuenta','¿A quién le prestarás?') !!}
{!! Form::select('cuenta',$data,null,['class' => 'form-control','onchange' => 'agregarLimite();','id' => 'cuenta']) !!}
</div>

<div class="form-group">
<label>Límite de Ahorro = </label>	
<b id="limiteCredito" name="limiteCredito">50000.00</b>
</div>


<div class="form-group">
{!! Form::label('opcionahorro','¿Cómo ahorrará esta persona?') !!}
{!! Form::select('opcionahorro',['M' => 'Ahorrará para cumplir una meta',
                                 'T' => 'Ahorrará hasta cumplir un plazo'],null,['class' => 'form-control','onchange' => 'aparecer();','id' => 'opcionahorro']) !!}
</div>

<div id="aparecer" style="width: 100%;">

<div class="form-group">
{!! Form::label('monto','¿Cuánto quieres que ahorre?') !!}
{!! Form::text('monto','0.00',['class' => 'form-control',
                               'placeholder' => 'No puede ser mayor al límite de crédito',
                               'onchange' => 'recalcularParcialidades();',
                               'onfocusin' => 'limpiarMonto();']) !!}
</div>

<div class="form-group">
Parcialidades de <span><b id="parcialidad">0.00</b></span>
{!! Form::hidden('parcialidad2',0.00,['class' => 'form-control','id' => 'parcialidad2']) !!}	
</div>	

<div class="form-group">
{!! Form::label('plazo','¿En cuánto tiempo deseas que llegue a su meta de ahorro?') !!}
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
{!! Form::label('fechaAcomodo','Selecciona el día en que realizará el primer abono') !!}
{!! Form::text('fechaAcomodo',null,['class' => 'datepicker form-control','readonly' => 'readonly',
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
Total:	<span><b id="totalPrestado">0.00</b></span>
{!! Form::hidden('totalprestado',0.00,['class' => 'form-control','id' => 'totalPrestado2']) !!}
</div>

<div class="form-group">
{!! Form::submit($SubmitButtonText,['class' => 'btn btn-primary form-control']) !!}
</div>

</div>

<div id="aparecer2" style="width: 100%; display: none;">
	
<div class="form-group">
{!! Form::label('plazoAhorro','¿Con qué frecuencia se abonará a la cuenta de ahorro?') !!}
{!! Form::select('plazoAhorro',['7' => 'Semanal','14' => 'Quincenal','30' => 'Mensual',
                          '60' => 'Bimestral','90' => 'Trimestral','180' => 'Semestral' ],
                          null,['class' => 'form-control','onchange' => 'recalcularParcialidades2();']) !!}
</div>	

<div class="form-group">
{!! Form::label('parcialidadAhorro','¿Cuánto crees que pueda ahorrar en cada plazo?') !!}
{!! Form::text('parcialidadAhorro','0.00',['class' => 'form-control',
                               'onkeyup' => 'recalcularParcialidades2();',
                               'onfocusin' => 'limpiarMonto();']) !!}
</div>

<div class="form-group">
{!! Form::label('fechaMeta','¿Cuándo deseas concluir el plan de ahorro?') !!}
{!! Form::text('fechaMeta',null,['class' => 'datepicker form-control','readonly' => 'readonly',
               'onchange' => 'calcularParcialidades2();']) !!}
</div>

<!-- Detalles -->
	
		<div style="width: 100%; padding-top: 20px; display: none;" id="act1ahorro">
		</div>

   <!-- Detalles -->
   	
	<!-- Detalles Móvil -->
	
	<div style="width: 100%; display: none;" id="actm1ahorro">
	</div>
		
	<!-- Detalles Móvil-->
	
	
    Total: <span><b id="totalAhorro">0.00</b></span> 
    <br />
	<input type="hidden" id="totalAhorroHidden" name="totalAhorroHidden"  value="0.00" size="20"  class="form-control" readonly="readonly"/>
	<br />
	

	
	<div class="submit-container" style="width: 100%; text-align: center;">
	<input type="submit" value="Guardar" style="width: 130px; height: 50px;" class="btn btn-primary" />
	</div>	
	
	
</div>	







