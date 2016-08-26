<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Services_Twilio;
/* use App\Http\Requests\SavingRequest; */


/*use Request;*/
use Auth;
use DB;


use App\Saving;
use App\Saving_Items;
use App\Clientes;
use Illuminate\Http\Request;
use App\Usuarios_sistema; 
use App\Preguntas;
use App\Encuesta_Clientes;

use Twilio\Sdk\Services\Twilio;

class SavingController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	   $datos = [];
	   $limites = "";
	   $resultados = Clientes::where('idusuario', '=', Auth::id())->get();		
       foreach ($resultados as $value){
       $datos[$value->id] = $value->nombrecompleto;
	   $limites = $limites.$value->limitecredito.",";	   
	   }
	   
     $limites = substr($limites,0,-1);  
	   
	   $data['data'] = $datos;
	   $data['limites'] = $limites;
		
	   return view('savings.create',$data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	

		$mplazo = "";
		$input = $request->all();
		$input['idusuario'] = Auth::id();		
		$input['idcliente'] = $request->get('cuenta');
		
		if($request->get('opcionahorro') == 'M')
		{
		$input['plazo'] = $request->get('plazo');
		$input['fechaprimerpago'] = $request->get('fechaAcomodo');
		$input['totalprestado'] = $request->get('totalprestado');
		$input['tipo_cobro'] = $request->get('tipo_cobroM');
		
/*		if($request->get('plazo') < 7)
	    $mplazo = $request->get('plazo')." quincenas";
	    else
        $mplazo = $request->get('plazo')." semanas"; */
        
           
		   $arregloPlazo = explode('_',$request->get('plazo')); 
		   if($arregloPlazo[1] == 'm')
		   $mplazo = $arregloPlazo[0]." meses";
		   else if($arregloPlazo[1] == 'q')
		   $mplazo = $arregloPlazo[0]." quincenas";
		   else if($arregloPlazo[1] == 's')
		   $mplazo = $arregloPlazo[0]." semanas";

		
		}else
		{	
		$input['plazo'] = $request->get('plazoAhorro');
		$input['fechaprimerpago'] = $request->get('fechaMeta');
		$input['totalprestado'] = $request->get('totalAhorroHidden');
		$input['tipo_cobro'] = $request->get('tipo_cobroT');

		
			if($request->get('plazoAhorro') == 7)
			$mplazo = "plazo semanal";
			else if($request->get('plazoAhorro') == 14)
            $mplazo = "plazo quincenal";
			else if($request->get('plazoAhorro') == 30)
            $mplazo = "plazo mensual"; 
			else if($request->get('plazoAhorro') == 60)
            $mplazo = "plazo bimestral"; 
			else if($request->get('plazoAhorro') == 90)
            $mplazo = "plazo trimestral";
			else if($request->get('plazoAhorro') == 180)
            $mplazo = "plazo semestral";   
		 
		}
		
		$input['status'] = '0';
		$input['tipo'] = $request->get('opcionahorro');
        $saved_saving =  Saving::create($input);
		
		$longitud = 0;
		$prefijo = '';
		$input_items['idprestamo'] = $saved_saving -> id;
		$input_items['idusuario'] = Auth::id();
		$input_items['idcliente'] = $request->get('cuenta');
		if($request->get('opcionahorro') == 'M')
		{
		$input_items['parcialidad'] = $request->get('parcialidad2');
		$longitud = $request->get('longitud');
		$prefijo = 'par';
		}else
		{
		$input_items['parcialidad'] = $request->get('parcialidadAhorro');
		$longitud = $request->get('longitudAhorro');
		$prefijo = 'parA';	
		}	
		$input_items['abonado'] = 0.00;
		$input_items['status'] = 0;
		$i=0;
		$arr = array(); 
		
		
		 while($i < $longitud)
          {
          	
          $nombreFecha = $prefijo.$i;	
          $input_items['fechacobro'] = $request->get($nombreFecha);   
		  $arr[$i] = $request->get($nombreFecha);  
          Saving_Items::create($input_items); 	
          $i++;	
          }  
		  
		
		return redirect('home');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data = [];
				  
		$resultados =  DB::table('ahorro')
            ->join('clientes', 'ahorro.idcliente', '=', 'clientes.id')
				  ->where('ahorro.idusuario','=',Auth::id())
				  ->select('clientes.nombrecompleto', 'ahorro.tipo', 
				           'ahorro.totalprestado','ahorro.status','ahorro.id as a_id','clientes.id as c_id')
            ->latest('ahorro.id') 
            ->paginate(10);
		
		$data['resultados'] = $resultados;	
		
		
		
		return view('savings.show',$data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	    $data = [];	
		$element = DB::select('SELECT c.id AS clieID, c.nombrecompleto AS nombrecompleto, c.telefono AS celular, p.plazo AS plazo, p.totalprestado AS totalprestado, 
                                           p.tipo AS tipo, p.id AS id, p.status AS status, p.estado_cobro AS estado_cobro  FROM clientes c, ahorro p WHERE
                                           p.id = ?  AND p.idcliente = c.id;', [$id]);
		
		$data['element'] = $element;
		
	    $element_item = DB::select('SELECT id,fechacobro,parcialidad,abonado FROM partidas_ahorro WHERE  idprestamo = ?;', [$id]);
		
		$data['element_item'] = $element_item;
		$data['element_id'] = $id;
		
		return view('savings.edit',$data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
	    $input = Saving_Items::findOrFail($request->get('id'));	
		$new_value['abonado'] = $request->get('parc');
		if($request->get('parc') == $request->get('compara'))
		$new_value['status'] = 1;
		else
		$new_value['status'] = 0;	
		$input -> update($new_value);
		
		$element_item = DB::select('SELECT status FROM partidas_ahorro WHERE  idprestamo = ?;', [$request->get('ven')]);
		$conteo = 0;
        $conteoStatus = 0;
        
        foreach($element_item as $item){
        $conteoStatus = $conteoStatus + $item->status; 	
        $conteo++;	
        }
		
		
		$inputSaving = Saving::findOrFail($request->get('ven'));
		
		if($conteo == $conteoStatus)
          {
          $new_value_status['status'] = 1;
          }else
          {
          $new_value_status['status'] = 0;		
          }	
		 $inputSaving -> update($new_value_status);
		
		return redirect('savings/'.$request->get('ven').'/edit');		
	}

	public function report()
	{
	

	$completo=[];
	$i = 0;
	
	
	$query1 = DB::select('SELECT DISTINCT c.id as id, c.nombrecompleto as nombrecompleto FROM clientes c 
	LEFT JOIN ahorro pr ON pr.idcliente = c.id WHERE  c.idusuario = ? 
	AND pr.idcliente IS NOT NULL ORDER BY c.id DESC', [Auth::id()]);
	
	
	foreach ($query1 as $row) {
	$o = 0;	
		
	$cuenta = [];
	$operacion = [];
	$operacionCompleta = [];	
		
	$cuenta ['id'] = $row -> id;
	$cuenta ['nombrecompleto'] = $row -> nombrecompleto;
		
	$query2 = DB::select('SELECT id,totalprestado,status FROM ahorro  WHERE 
	idcliente = ? ORDER BY id DESC;', [$row -> id]);
	
	foreach ($query2 as $row2) {
		
	$operacion ['id'] = $row2 -> id;
	$operacion ['totalprestado'] = $row2 -> totalprestado;
	$operacion ['status'] = $row2 -> status;
		
	$query3 = DB::select('SELECT SUM(p.abonado) AS parcialidad FROM partidas_ahorro p WHERE  
	p.idprestamo = ?;', [$row2 -> id]);
	
	foreach ($query3 as $row3) {	
	$operacion ['parcialidad'] = $row3 -> parcialidad;		
	}	
	
	$query4 = DB::select('SELECT fechacobro,status FROM partidas_ahorro WHERE  
	idprestamo = ? AND status = \'0\' LIMIT 1;', [$row2 -> id]);
	
	$operacion ['fechacobro'] = 'Completado';
	foreach ($query4 as $row4) {	
	$operacion ['fechacobro'] = $row4 -> fechacobro;
	}
	$operacionCompleta[$o++] = $operacion;
	}	
	
	$cuenta['operacion'] = $operacionCompleta;	
	$completo[$i++] = $cuenta;	
	}
	
	$data['cuentas'] = $completo;
	
	//return $data['cuentas'];
	return view('savings.report',$data);
		
	}

   function backup(){
   	
		$contador=1;
		$junto = "";
   	
	   $resultados = Clientes::where('idusuario', '=', Auth::id())->get();		
       foreach ($resultados as $value){
	   
	    $junto .= "</br>";
		$junto .= "</br>";
	    $junto .= "Respaldo: ".date("Y-m-d H:i:s");
		$junto .= "</br>";
		$junto .= "</br>";
		$junto .= "===============CUENTA=============</br>";	
		$junto .= "Nombre: ".utf8_decode ($value->nombrecompleto)."</br>";	
		$junto .= "Celular: ".$value->celular."</br>";
		$junto .= "Ingreso Mensual: ".$value->ingresomensual."</br>";
		$junto .= "Limite Credito: ".$value->limitecredito."</br>";
		$junto .= "==================================</br>";
	   
	   	$operaciones = Saving::where('idcliente', '=', $value->nombrecompleto)->get();	
	    foreach ($operaciones as $operacion){
	   	
		$contador=1;
		$junto .= "//////////////AHORRO/////////////</br>";
		$junto .= "Fecha Ahorro: ".$operacion -> fechaprimerpago."</br>";
		$junto .= "Total a ahorrar: ".$operacion -> totalprestado."</br>";
        $junto .= "Pagar en: ".$operacion -> tipo_cobro."</br>";
		
		
		if($operacion -> tipo == 'M')
		{
	    if(substr($operacion -> plazo, -1) == 'm' || substr($operacion -> plazo, -1) == 'm' || substr($operacion -> plazo, -1) == 's')
			{
		$arregloPlazo = explode('_',$operacion -> plazo); 
			if($arregloPlazo[1] == 'm')
				$junto .= "Plazo: ".$arregloPlazo[0]." meses";
			elseif($arregloPlazo[1] == 'q')
				$junto .= "Plazo: ".$arregloPlazo[0]." quincenas";
			elseif($arregloPlazo[1] == 's')
				$junto .= "Plazo: ".$arregloPlazo[0]." semanas";
			}	
		else
			{
		if($operacion -> plazo < 7) //esto por la compatibilidad con los que no tienen la nomenclatura nueva
			$junto .="Plazo: ". $operacion -> plazo." quincenas";
		else
			$junto .= "Plazo: ".$operacion -> plazo." semanas";
			}
		}else{
			
			if($operacion -> plazo == 7)
			$junto .= "Plazo semanal";
			else if($operacion -> plazo == 14)
            $junto .= "Plazo quincenal";
			else if($operacion -> plazo == 30)
            $junto .= "Plazo mensual"; 
			else if($operacion -> plazo == 60)
            $junto .= "Plazo bimestral"; 
			else if($operacion -> plazo == 90)
            $junto .= "Plazo trimestral";
			else if($operacion -> plazo == 180)
            $junto .= "Plazo semestral";   
			
		}
		
		
	    if($operacion -> status == 0)
		$junto .= "Estado: "."Pendiente"."</br>";
		else 	
		$junto .= "Estado: "."Concluido"."</br>";
		$junto .= "///////////////////////////////////////////</br>";
		
		$operaciones_items = Saving_Items::where('idprestamo', '=', $operacion -> id)->get();	
	    foreach ($operaciones_items as $item){
		
		 $junto .= "#################Partida ".$contador."####################</br>";	
		$junto .= "Fecha de Abono: ".$item -> fechacobro."</br>";
		$junto .= "Parcialidad: ".$item -> parcialidad."</br>";
		$junto .= "Abonado: ".$item -> abonado."</br>";	
	    if($item -> status == 0)
		$junto .= "Estado: "."Pendiente"."</br>";
		else 	
		$junto .= "Estado: "."Concluido"."</br>";	
		$junto .= "###########################################</br>";
		$contador++;
		   
	   }
	   }
	
	}


		 $user = Usuarios_sistema::findOrFail(Auth::user()->id);	

         $subject = 'Respaldo Reporte';

         $headers = "From: correo@dominio.com\r\n"; //Cambiar correo@dominio.com por correo real 
         $headers .= "MIME-Version: 1.0\r\n";
         $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

         $message = '<html><head></head><body>';
         $message .= $junto;
         $message .= "</body></html>";


         mail($user->correoelectronico, $subject, $message, $headers);
	
	return view('savings.backup');
   }





	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
