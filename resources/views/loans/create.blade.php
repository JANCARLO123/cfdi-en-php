@extends('calendar_app')

@section('content')

<link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet">

<!-- Zona JS -->
<script src="{{ asset('assets/plugins/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-ui.js') }}"></script>
<script>
 
  $(function() {
  	
  	
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);  	
  	
  	
 $( ".datepicker" ).datepicker({ dateFormat: 'yy/mm/dd' });
    
    
    var meses = new Array("01", "02", "03", 
    "04", "05", "06", "07", "08", "09", 
    "10", "11", "12");
    
    var ahora = new Date();
    
    var curr_date = ahora.getDate();
    var curr_month = ahora.getMonth();
    var curr_year = ahora.getFullYear();
    
    document.getElementById('fechaprestamo').value = curr_year+ "/"+meses[curr_month] + "/" + curr_date;
  });
  
   function getMobileOperatingSystem() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;

  if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) )
  {
    return 'iOS';

  }
  else if( userAgent.match( /Android/i ) )
  {

    return 'Android';
  }
  else
  {
    return 'Android';
  }
}

 function limpiarMonto()
    {
    
    if(document.getElementById('monto').value == '0.00')
    {
    document.getElementById('monto').value = '';	
    }	
    
    }
  
  
    function calcularRendimiento(){
    	

  	var e = document.getElementById("porcentajeRendimiento");
    var val = e.options[e.selectedIndex].value;
  	rendimiento = parseFloat(document.getElementById('monto').value * val).toFixed(2);
  	document.getElementById('rendimientoTotal').innerText = rendimiento;
  	document.getElementById('rendimiento').value = rendimiento;
  	agregarTotal(); 	
  	
  	return true;
  }
  
  function calcularAhorro(){
  	
 	
  	
  	
  	var e = document.getElementById("porcentajeAhorro");
    var val = e.options[e.selectedIndex].value;
  	rendimiento = parseFloat(document.getElementById('monto').value * val).toFixed(2);
  	document.getElementById('ahorroTotal').innerText = rendimiento;
  	document.getElementById('ahorro').value = rendimiento;
  	agregarTotal(); 	
  	
  	return true;
  }	
  
  function recalcularParcialidades()
  {
  	agregarTotal();
  	if(document.getElementById('act1').style.display == 'inline-block' 
  	|| document.getElementById('actm1').style.display == 'inline-block')
  	{  		
  	calcularParcialidades();
  	}
  }
  
  
  function calcularParcialidades()
  {
  	var a=document.getElementById('act1');
    while(a.hasChildNodes())
	a.removeChild(a.firstChild);	
	
	var b=document.getElementById('actm1');
    while(b.hasChildNodes())
	b.removeChild(b.firstChild);	
	
	/* Versión Normal */
	
	/*Encabezados*/
	var titulo = document.createElement("div");
	titulo.style.width='100%';
	titulo.style.textAlign="center";
	titulo.style.fontSize="14pt";
	titulo.style.paddingBottom="10px";
    titulo.appendChild(document.createTextNode('Calendario de Pagos')); 
    document.getElementById('act1').appendChild(titulo);	
     
 	var titulom = document.createElement("div");
	titulom.style.width='100%';
    titulom.appendChild(document.createTextNode('Calendario de Pagos'));
    titulom.style.textAlign="center"; 
    titulom.style.fontSize="14pt";
    titulom.style.paddingBottom="10px";
    document.getElementById('actm1').appendChild(titulom);	
  	
  	var division = document.createElement("div");
    division.style.width='34%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pago')); /*Número consecutivo*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='23%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Fecha')); /*Fecha*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Cobro')); /*Parcialidad*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Status')); /*Status*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
    
  
    
    
    /*Fin encabezados*/
  	
  	var iteraciones =  document.getElementById('plazo').value;
  	var iterar = 0;
  	var parcial = 1;
  	var parcialm = 1;  	
  	var fecha = $("#fechaprimerpago").val();
  	
  	while(iterar < parseInt(iteraciones))
  	{
    var division = document.createElement("div");
    division.style.width='34%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(parcial++)); /*Número consecutivo*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='23%';
    division.style.height='40px';
    division.style.display='inline-table';   
    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(fecha)); /*Fecha*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
  
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(document.getElementById('parcialidad2').value)); /*Parcialidad*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pendiente')); /*Status*/
    division.appendChild(seccion);
    document.getElementById('act1').appendChild(division);	
    

    
    /* Versión Normal */
    

    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pago')); /*Mensaje*/
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='45%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(parcialm++)); /*Mensaje*/
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Fecha')); /*Mensaje*/
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
        var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(fecha)); /*Fecha*/
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Cobro'));
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='45%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(document.getElementById('parcialidad2').value)); /*Cobro*/
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Status')); 
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='45%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pendiente')); 
    division.appendChild(seccion);
    document.getElementById('actm1').appendChild(division);	
    
    
    var esconder = document.createElement("input");
    esconder.type ='hidden';
    esconder.value=fecha;
    esconder.id='par'+iterar;
    esconder.name='par'+iterar;
    document.getElementById('formaPrestamos').appendChild(esconder);
    
    
    var numberOfDaysToAdd = 0; 
   /* if(parseInt(iteraciones)<7)
    numberOfDaysToAdd = 14;
    else
    numberOfDaysToAdd = 7; */
if(iteraciones == '1_m' || iteraciones == '2_m' || iteraciones == '3_m' || iteraciones == '4_m' ||
   iteraciones == '5_m' ||iteraciones == '6_m')
   numberOfDaysToAdd = 30;
else if(iteraciones == '4_q' || iteraciones == '5_q' || iteraciones == '6_q' || iteraciones == '7_q' ||
   iteraciones == '8_q' ||iteraciones == '9_q'||iteraciones == '10_q' ||iteraciones == '11_q'||iteraciones == '12_q')
   numberOfDaysToAdd = 14;   
else if(iteraciones == '8_s' || iteraciones == '10_s' || iteraciones == '12_s' || iteraciones == '14_s' ||
   iteraciones == '16_s' ||iteraciones == '18_s'||iteraciones == '20_s' ||iteraciones == '22_s'||iteraciones == '24_s')
   numberOfDaysToAdd = 7;   
    
    var someDate = new Date(fecha);
	
	if(numberOfDaysToAdd == 30)
	someDate = new Date(new Date(someDate).setMonth(someDate.getMonth()+1));
	else
	someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
 
	var dd = '' + someDate.getDate();
	var mm = '' + (someDate.getMonth() + 1);
	var y = someDate.getFullYear();

     
    if (mm.length < 2) mm = '0' + mm;
    if (dd.length < 2) dd = '0' + dd;
 
	fecha = y +'/'+ mm +'/'+dd;
    
    

    
    
    iterar++;
   }
  
  var esconder = document.createElement("input");
    esconder.type ='hidden';
    esconder.value=iterar;
    esconder.id='longitud';
    esconder.name='longitud';
    document.getElementById('formaPrestamos').appendChild(esconder);
  
  
  if (window.matchMedia('(max-width: 700px)').matches) {
 document.getElementById('act1').style.display = 'none';
 document.getElementById('actm1').style.display = 'inline-block';  	
   }
  else
   {	
  document.getElementById('act1').style.display = 'inline-block';
  document.getElementById('actm1').style.display = 'none'; 	
   }
  
  }
  
  function agregarTotal(){
  	document.getElementById('totalprestado').value = '';
  	document.getElementById('totalPrestadoB').innerText = '';
  	
  	document.getElementById('totalprestado').value = 
  	parseFloat(parseFloat(document.getElementById('rendimiento').value) + 
  	parseFloat(document.getElementById('monto').value) +  
  	parseFloat(document.getElementById('ahorro').value)).toFixed(2);
  	
  	document.getElementById('totalPrestadoB').innerText = 
  	parseFloat(parseFloat(document.getElementById('rendimiento').value) + 
  	parseFloat(document.getElementById('monto').value) +  
  	parseFloat(document.getElementById('ahorro').value)).toFixed(2);
  	
  	parcialidad = parseFloat(document.getElementById('totalprestado').value) / parseFloat(document.getElementById('plazo').value); 
  	document.getElementById('parcialidad2').value = parseFloat(parcialidad).toFixed(2);
  	document.getElementById('parcialidad').innerText = parseFloat(parcialidad).toFixed(2);
  	
  	if(parseFloat(document.getElementById('totalprestado').value) <= parseFloat(document.getElementById('limiteCredito').innerText))
  	{
  	document.getElementById('totalPrestadoB').style.color = 'black';	
  	}else
  	{
  	document.getElementById('totalPrestadoB').style.color = 'red';
  	}
  }
  
  function esFecha(txtDate)
{
    var currVal = txtDate;
    if(currVal == '')
        return false;
    
    var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; 
    var dtArray = currVal.match(rxDatePattern); 
    
    if (dtArray == null) 
        return false;
    
    //Checks for mm/dd/yyyy format.
    dtMonth = dtArray[3];
    dtDay= dtArray[5];
    dtYear = dtArray[1];        
    
    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
                return false;
    }
    return true;
}


  
  function validarForma(){
  	
  	var val = true;
  	var b=document.getElementById('error_js');
  	b.style.display = 'none';
  	
    while(b.hasChildNodes())
	b.removeChild(b.firstChild);  	  	
  	  	
  	if(isNaN(document.getElementById('totalprestado').value))
  	{
  	var li = document.createElement("li");	
  	li.appendChild(document.createTextNode('Error al llenar campos, verifique que el monto sea numérico'));
  	b.appendChild(li);
  	val = false;
  	}
  	
  	if(!esFecha(document.getElementById('fechaprestamo').value))
  	{
  	var li = document.createElement("li");	
  	li.appendChild(document.createTextNode('Error en el campo de fecha para hacer el desembolso'));
  	b.appendChild(li);
  	val = false;	
  	}
  	
  	if(!esFecha(document.getElementById('fechaprimerpago').value))
  	{
  	var li = document.createElement("li");	
  	li.appendChild(document.createTextNode('Error en el campo de fecha en que te acomoda que te pague'));
  	b.appendChild(li);
  	val = false;
  	}
  	
  	if(document.getElementById('act1').style.display == 'none' 
  	&& document.getElementById('actm1').style.display == 'none')
  	{
  	var li = document.createElement("li");	
  	li.appendChild(document.createTextNode('La tabla de parcialidades no ha sido desplegada'));
  	b.appendChild(li);
  	val = false;
  	}
  	
  	  	

  	
  	if(val == false)
  	{
    b.style.display = 'inline-block';
  	window.scrollTo(0,0);
  	}
  	
  	
  	return val;
  }
    
     function agregarLimite()
  {

  	 var arrayJS=[{{ $limites }}];
     document.getElementById('limiteCredito').innerText=arrayJS[document.getElementById('cuenta').selectedIndex];
     agregarTotal();
   }	 
    
    
    
  </script>

<!-- Zona JS -->

<h3>Crea un nuevo préstamo</h3>

<hr />

	<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Crear</div>
				<div class="panel-body">
				

@include('errors.list')
<ul id="error_js" class="alert alert-danger" style="display: none;">
</ul>

{!! Form::open(['url' => 'loans','id' => 'formaPrestamos','onsubmit' => 'return validarForma();']) !!}

@include('loans.form',['SubmitButtonText' => 'Crear Préstamo'])

{!! Form::close() !!}

</div>
</div>
</div>
</div>
</div>

<script>
	
	$( document ).ready(function() {
    agregarLimite();
    });
	
</script>

@stop	