@extends('calendar_app')

@section('content')

<link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet">

<!-- Zona JS -->
<script src="{{ asset('assets/plugins/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-ui.js') }}"></script>

<!-- Fin JS -->	

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
    

  });
    
  </script>
  
  <script>
  
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


  
   function aparecer(){
   	
   	
   	document.getElementById('aparecer').style.display= 'none';
   	document.getElementById('aparecer2').style.display= 'none';
   	
   	var e = document.getElementById("opcionahorro");
    var op = e.options[e.selectedIndex].value;
   	
   	if(op == 'M')
  	document.getElementById('aparecer').style.display= 'inline-block';
  	else if(op == 'T')
  	document.getElementById('aparecer2').style.display= 'inline-block';
  	
  	
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
    titulo.appendChild(document.createTextNode('Calendario de Abonos')); 
    document.getElementById('act1').appendChild(titulo);	
     
 	var titulom = document.createElement("div");
	titulom.style.width='100%';
    titulom.appendChild(document.createTextNode('Calendario de Abonos'));
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
    seccion.appendChild(document.createTextNode('Abono')); /*Parcialidad*/
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
  	var fecha = $("#fechaAcomodo").val();
  	
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
    seccion.appendChild(document.createTextNode('Abono'));
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
  /*  if(parseInt(iteraciones)<7)
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
  
  
    function recalcularParcialidades2()
  {
  	if(document.getElementById('act1ahorro').style.display == 'inline-block' 
  	|| document.getElementById('actm1ahorro').style.display == 'inline-block')
  	{  		
  	calcularParcialidades();
  	}
  }
  
   function calcularParcialidades2()
  {
  	var a=document.getElementById('act1ahorro');
    while(a.hasChildNodes())
	a.removeChild(a.firstChild);	
	
	var b=document.getElementById('actm1ahorro');
    while(b.hasChildNodes())
	b.removeChild(b.firstChild);	
	
	/* Versión Normal */
	
	/*Encabezados*/
	var titulo = document.createElement("div");
	titulo.style.width='100%';
	titulo.style.textAlign="center";
	titulo.style.fontSize="14pt";
	titulo.style.paddingBottom="10px";
    titulo.appendChild(document.createTextNode('Calendario de Abonos')); 
    document.getElementById('act1ahorro').appendChild(titulo);	
     
 	var titulom = document.createElement("div");
	titulom.style.width='100%';
    titulom.appendChild(document.createTextNode('Calendario de Abonos'));
    titulom.style.textAlign="center"; 
    titulom.style.fontSize="14pt";
    titulom.style.paddingBottom="10px";
    document.getElementById('actm1ahorro').appendChild(titulom);	
  	
  	var division = document.createElement("div");
    division.style.width='34%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pago')); /*Número consecutivo*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='23%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Fecha')); /*Fecha*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Abono')); /*parcialidadAhorro*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#337ab7';
    division.style.color='white';    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Status')); /*Status*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
    

    
    
    
    /*Fin encabezados*/
  	
  	var iteraciones =  document.getElementById('plazoAhorro').value;
  	var iterar = 0;
  	var parcial = 1;
  	var parcialm = 1;  	
  	var fechaSeleccionada = $("#fechaMeta").val();
  	var fechaMeta = new Date(fechaSeleccionada);
  	var fechaActual =  new Date();
    var parcialidadTotal = 0;

    
    
  	
  	while(fechaActual <= fechaMeta)
  	{
  		
  	var dd = '' + fechaActual.getDate();
	var mm = '' + (fechaActual.getMonth() + 1);
	var y = fechaActual.getFullYear();

     
    if (mm.length < 2) mm = '0' + mm;
    if (dd.length < 2) dd = '0' + dd;
 
	fecha = y +'/'+ mm +'/'+dd;	
  		
    var division = document.createElement("div");
    division.style.width='34%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(parcial++)); /*Número consecutivo*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='23%';
    division.style.height='40px';
    division.style.display='inline-table';   
    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(fecha)); /*Fecha*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
  
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(document.getElementById('parcialidadAhorro').value)); /*parcialidadAhorro*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='20%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pendiente')); /*Status*/
    division.appendChild(seccion);
    document.getElementById('act1ahorro').appendChild(division);	
    
    /* Versión Normal */
    

    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#004b9c';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pago')); /*Mensaje*/
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='45%';
    division.style.height='40px';
    division.style.display='inline-table';
    division.style.background='#004b9c';
    division.style.color='white';
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(parcialm++)); /*Mensaje*/
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Fecha')); /*Mensaje*/
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
        var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(fecha)); /*Fecha*/
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Abono'));
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='45%';
    division.style.height='40px';
    division.style.display='inline-table';
    
    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode(document.getElementById('parcialidadAhorro').value)); /*Cobro*/
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='50%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Status')); 
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
    var division = document.createElement("div");
    division.style.width='45%';
    division.style.height='40px';
    division.style.display='inline-table';

    
    var seccion = document.createElement("span");
    seccion.appendChild(document.createTextNode('Pendiente')); 
    division.appendChild(seccion);
    document.getElementById('actm1ahorro').appendChild(division);	
    
    
    var esconder = document.createElement("input");
    esconder.type ='hidden';
    esconder.value=fecha;
    esconder.id='parA'+iterar;
    esconder.name='parA'+iterar;
    document.getElementById('formaPrestamos').appendChild(esconder);
    
    var numberOfDaysToAdd = 0; 
    var numberOfMonthsToAdd = 0;
    var e = document.getElementById("plazoAhorro");
    var valor = e.options[e.selectedIndex].value;
    
    if(valor == 7)    
    numberOfDaysToAdd = 7;    
    else if (valor == 14)
    numberOfDaysToAdd = 14;    
    else if (valor == 30)
    numberOfMonthsToAdd = 1;
    else if (valor == 60)
    numberOfMonthsToAdd = 2;
    else if (valor == 90)
    numberOfMonthsToAdd = 3;    
    else if (valor == 180)
    numberOfMonthsToAdd = 6;
    
    var someDate = new Date(fechaActual);
	
	someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
	someDate.setMonth(someDate.getMonth() + numberOfMonthsToAdd);
 
	var dd = '' + someDate.getDate();
	var mm = '' + (someDate.getMonth() + 1);
	var y = someDate.getFullYear();

     
    if (mm.length < 2) mm = '0' + mm;
    if (dd.length < 2) dd = '0' + dd;
 
	fechaActual = someDate;
	parcialidadTotal = parcialidadTotal + parseFloat(document.getElementById('parcialidadAhorro').value);
	iterar++;	
   }
  
  var esconder = document.createElement("input");
    esconder.type ='hidden';
    esconder.value=iterar;
    esconder.id='longitudAhorro';
    esconder.name='longitudAhorro';
    document.getElementById('formaPrestamos').appendChild(esconder);
  
  
  if (window.matchMedia('(max-width: 700px)').matches) {
 document.getElementById('act1ahorro').style.display = 'none';
 document.getElementById('actm1ahorro').style.display = 'inline-block';  	
   }
  else
   {	
  document.getElementById('act1ahorro').style.display = 'inline-block';
  document.getElementById('actm1ahorro').style.display = 'none'; 	
   }
   
   document.getElementById('totalAhorro').innerText = parseFloat(parcialidadTotal).toFixed(2);
   document.getElementById('totalAhorroHidden').value = parseFloat(parcialidadTotal).toFixed(2);
   
  }
  
  function agregarTotal(){
  	document.getElementById('totalPrestado2').value = '';
  	document.getElementById('totalPrestado').innerText = '';
  	
  	document.getElementById('totalPrestado2').value =  
  	parseFloat(document.getElementById('monto').value).toFixed(2);
  	
  	document.getElementById('totalPrestado').innerText = 
  	parseFloat(document.getElementById('monto').value).toFixed(2);
  	
  	parcialidad = parseFloat(document.getElementById('totalPrestado2').value) / parseFloat(document.getElementById('plazo').value); 
  	document.getElementById('parcialidad2').value = parseFloat(parcialidad).toFixed(2);
  	document.getElementById('parcialidad').innerText = parseFloat(parcialidad).toFixed(2);
  	
  	if(parseFloat(document.getElementById('totalPrestado2').value) <= parseFloat(document.getElementById('limiteCredito').innerText))
  	{
  	document.getElementById('totalPrestado').style.color = 'black';	
  	}else
  	{
  	document.getElementById('totalPrestado').style.color = 'red';
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
  	
  
  	
  	
  	var e = document.getElementById("opcionahorro");
    var op = e.options[e.selectedIndex].value;
   	
   	if(op == 1)
   	{
    document.getElementById('seccionError').style.display = 'none';
  	
  	var b=document.getElementById('seccionError');
    while(b.hasChildNodes())
	b.removeChild(b.firstChild);		
  	  	
  	  	
  	if(isNaN(document.getElementById('totalPrestado2').value))
  	{
  	document.getElementById('seccionError').appendChild(document.createTextNode('Error al llenar campos, verifique que el monto sea numérico'));
  	document.getElementById('seccionError').style.display = 'inline-block';
  	window.scrollTo(0,0);
  	return false;	
  	}
  	
  	
  	if(!esFecha(document.getElementById('fechaAcomodo').value))
  	{
  	document.getElementById('seccionError').appendChild(document.createTextNode('Error en el campo de fecha en que se realizará el primer abono'));
  	document.getElementById('seccionError').style.display = 'inline-block';
  	window.scrollTo(0,0);
  	return false;  		
  	}
  	
  	if(document.getElementById('act1').style.display == 'none' 
  	&& document.getElementById('actm1').style.display == 'none')
  	{
  	document.getElementById('seccionError').appendChild(document.createTextNode('La tabla de parcialidades no ha sido desplegada'));
  	document.getElementById('seccionError').style.display = 'inline-block';
  	window.scrollTo(0,0);
  	return false;  		
  	}
  	
  	  	
  	
  	document.getElementById('formaPrestamos').action = "agregarAhorro.php";
  	
  	return true;
  	}
  	else if(op == 2)
  	{
  	document.getElementById('formaPrestamos').action = "agregarAhorroTiempo.php";
  	
  	return true;
  	}
  	
  	
  	
  }
  
     function agregarLimite()
  {

  	 var arrayJS=[{{ $limites }}];
     document.getElementById('limiteCredito').innerText=arrayJS[document.getElementById('cuenta').selectedIndex];
     agregarTotal();
   }
   
    function limpiarMonto()
    {
    
    if(document.getElementById('monto').value == '0.00')
    {
    document.getElementById('monto').value = '';	
    }	
    
    }
  	
    	
  </script>

<!-- Zona JS -->

<h3>Crea un nuevo ahorro</h3>

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


{!! Form::open(['url' => 'savings','id' => 'formaPrestamos','onsubmit' => 'return validarForma();']) !!}

@include('savings.form',['SubmitButtonText' => 'Crear Ahorro'])

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