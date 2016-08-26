<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use Illuminate\Http\Request; 
use Services_Twilio;

/* use Request; */
use Auth;
use DB;


use App\Loan;
use App\Loan_Items;
use App\Clientes;
use App\Usuarios_sistema;
use App\Preguntas;
use App\Encuesta_Clientes;

class LoanController extends Controller {


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
		
	   return view('loans.create',$data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LoanRequest $request)
	{
		$input = $request->all();
		$input['idusuario'] = Auth::id();
		$input['status'] = '0';		
		$saved_loan =  Loan::create($input);
		$input_items['idprestamo'] = $saved_loan -> id;
		$input_items['idusuario'] = Auth::id();
		$input_items['idcliente'] = $request->get('idcliente');
		$input_items['parcialidad'] = $request->get('parcialidad2');
		$input_items['abonado'] = 0.00;
		$input_items['status'] = 0;
		$i=0;
		$arr = array(); 
		 while($i < $request->get('longitud'))
          {
          $nombreFecha = 'par'.$i;	
          $input_items['fechacobro'] = $request->get($nombreFecha); 
		  $arr[$i] = $request->get($nombreFecha);  
          Loan_Items::create($input_items); 	
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
				  
		$resultados =  DB::table('prestamo')
            ->join('clientes', 'prestamo.idcliente', '=', 'clientes.id')
				  ->where('prestamo.idusuario','=',Auth::id())
				  ->select('clientes.nombrecompleto', 'prestamo.fechaprestamo', 
				           'prestamo.totalprestado','prestamo.status','prestamo.id as p_id','clientes.id as c_id')
            ->latest('prestamo.id') 
            ->paginate(10);	
		
		$data['resultados'] = $resultados;	
		
		return view('loans.show',$data);
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
		$element = DB::select('SELECT c.id AS clieID, c.nombrecompleto AS nombrecompleto, p.plazo AS plazo, p.totalprestado AS totalprestado, 
                                           p.ahorro AS ahorro, p.rendimiento AS rendimiento, p.id AS id, p.status AS status, p.estado_cobro AS estado_cobro FROM clientes c, prestamo p WHERE
                                           p.id = ?  AND p.idcliente = c.id;', [$id]);
		
		
		$data['element'] = $element;
		
		
	    $element_item = DB::select('SELECT id,fechacobro,parcialidad,abonado FROM partidas_prestamo WHERE  idprestamo = ?;', [$id]);
		
		$data['element_item'] = $element_item;
		$data['element_id'] = $id;
		
		return view('loans.edit',$data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
	    $input = Loan_Items::findOrFail($request->get('id'));	
		$new_value['abonado'] = $request->get('parc');
		if($request->get('parc') == $request->get('compara'))
		$new_value['status'] = 1;
		else
		$new_value['status'] = 0;	
		$input -> update($new_value);
		
		$element_item = DB::select('SELECT status FROM partidas_prestamo WHERE  idprestamo = ?;', [$request->get('ven')]);
		$conteo = 0;
        $conteoStatus = 0;
        
        foreach($element_item as $item){
        $conteoStatus = $conteoStatus + $item->status; 	
        $conteo++;	
        }
		
		
		$inputLoan = Loan::findOrFail($request->get('ven'));
		
		if($conteo == $conteoStatus)
          {
          $new_value_status['status'] = 1;
          }else
          {
          $new_value_status['status'] = 0;		
          }	
		 $inputLoan -> update($new_value_status);
		
		return redirect('loans/'.$request->get('ven').'/edit');		
	}
	
	public function report()
	{
	

	$completo=[];
	$i = 0;
	
	
	$query1 = DB::select('SELECT DISTINCT c.id as id, c.nombrecompleto as nombrecompleto FROM clientes c 
	LEFT JOIN prestamo pr ON pr.idcliente = c.id WHERE  c.idusuario = ? 
	AND pr.idcliente IS NOT NULL ORDER BY c.id DESC', [Auth::id()]);
	
	
	foreach ($query1 as $row) {
	$o = 0;	
		
	$cuenta = [];
	$operacion = [];
	$operacionCompleta = [];	
		
	$cuenta ['id'] = $row -> id;
	$cuenta ['nombrecompleto'] = $row -> nombrecompleto;
		
	$query2 = DB::select('SELECT id,totalprestado,ahorro,rendimiento,status FROM prestamo  WHERE 
	idcliente = ? ORDER BY id DESC;', [$row -> id]);
	
	foreach ($query2 as $row2) {
		
	$operacion ['id'] = $row2 -> id;
	$operacion ['totalprestado'] = $row2 -> totalprestado;
	$operacion ['ahorro'] = $row2 -> ahorro;
	$operacion ['rendimiento'] = $row2 -> rendimiento;
	$operacion ['status'] = $row2 -> status;	
		
	$query3 = DB::select('SELECT SUM(p.abonado) AS parcialidad FROM partidas_prestamo p WHERE  
	p.idprestamo = ?;', [$row2 -> id]);
	
	foreach ($query3 as $row3) {	
	$operacion ['parcialidad'] = $row3 -> parcialidad;		
	}	
	
	$query4 = DB::select('SELECT fechacobro,status FROM partidas_prestamo WHERE  
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
	return view('loans.report',$data);
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	 
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
	   
	   	$operaciones = Loan::where('idcliente', '=', $value->nombrecompleto)->get();	
	    foreach ($operaciones as $operacion){
	   	
		$contador=1;
		$junto .= "//////////////PRESTAMO/////////////</br>";
		$junto .= "Fecha Prestamo: ".$operacion -> fechaprestamo."</br>";
		$junto .= "Fecha Primer Pago: ".$operacion -> fechaprimerpago."</br>";
		$junto .= "Total Prestado: ".$operacion -> totalprestado."</br>";
		$junto .= "Ahorro: ".$operacion -> ahorro."</br>";
		$junto .= "Rendimiento: ".$operacion -> rendimiento."</br>";
		$junto .= "Pagar en: ".$operacion -> tipo_cobro."</br>";
		
		
		if(substr($operacion -> plazo, -1) == 'm' || substr($operacion -> plazo, -1) == 'm' || substr($operacion -> plazo, -1) == 's')
			{
		$arregloPlazo = explode('_',$operacion -> plazo); 
			if($arregloPlazo[1] == 'm')
				$junto .= $arregloPlazo[0]." meses";
			elseif($arregloPlazo[1] == 'q')
				$junto .= $arregloPlazo[0]." quincenas";
			elseif($arregloPlazo[1] == 's')
				$junto .= $arregloPlazo[0]." semanas";
			}	
		else  //esto por la compatibilidad con los que no tienen la nomenclatura nueva
			{
		if($operacion -> plazo < 7)
			$junto .= $operacion -> plazo." quincenas";
		else
			$junto .= $operacion -> plazo." semanas";
			}
		
		
	    if($operacion -> status == 0)
		$junto .= "Estado: "."Pendiente"."</br>";
		else 	
		$junto .= "Estado: "."Pagado"."</br>";
		$junto .= "///////////////////////////////////////////</br>";
		
		$operaciones_items = Loan_Items::where('idprestamo', '=', $operacion -> id)->get();	
	    foreach ($operaciones_items as $item){
		
		$junto .= "#################Partida ".$contador."####################</br>";	
		$junto .= "Fecha Cobro: ".$item -> fechacobro."</br>";
		$junto .= "Parcialidad: ".$item -> parcialidad."</br>";
		$junto .= "Abonado: ".$item -> abonado."</br>";	
	    if($item -> status == 0)
		$junto .= "Estado: "."Pendiente"."</br>";
		else 	
		$junto .= "Estado: "."Pagado"."</br>";	
		$junto .= "###########################################</br>";
		$contador++;
		   
	   }
	   }
	
	}


		 $user = Usuarios_sistema::findOrFail(Auth::user()->id);	

         $subject = 'Respaldo Reporte';

         $headers = "From: correo@dominio.com\r\n"; //Cambiar por correo del dominio real 
         $headers .= "MIME-Version: 1.0\r\n";
         $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

         $message = '<html><head></head><body>';
         $message .= $junto;
         $message .= "</body></html>";


         mail($user->correoelectronico, $subject, $message, $headers);
		
	
		return view('loans.backup');
   }
	 

	 
	 
	public function destroy($id)
	{
		//
	}

}
