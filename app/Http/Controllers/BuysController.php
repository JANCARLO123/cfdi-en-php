<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PDF;
use Auth;
use Response;
use Conekta;
use Conekta_Charge;
use Conekta_Error;
use SimpleXMLElement;

use App\Http\Requests\BuyRequest;
use App\Usuarios_sistema;
use App\Compras;
use App\CFDI_Compras;
use App\Compras_Documento;
use App\FormatosCFDI;
use App\FormatosUsuario;

class BuysController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function buyInvoice()
	{
	return view('shop.buyinvoice');
	}
	
	public function manageInvoiceBuy(BuyRequest $request)
	{
						
		if (Auth::attempt(array('email' => Auth::user()->email, 'password' => $request->pwd)))
		{
			
		$id_usuario = "";
		$input = Usuarios_sistema::findOrFail(Auth::id());
		
		//Calcular importe
		
		$total = $request->get('pedido') * 2;
		$total = $total * 1.16;
		$venta = $total * 100;
		
		$subtotal = $request->get('pedido') * 2;
		$iva = $subtotal * 0.16;
		$importe_total = $subtotal + $iva;
		
		//Calcular importe
		Conekta::setApiKey("ApiKey"); //Se cambia por la llave privada de conekta
		
		Conekta::setLocale('es');
		
		if(Auth::user()->forma_pago == 0)
		{
			
		//Se captura la referencia	
		$numfolio = 0;
		$folio = Compras::where('id_usuario','=',Auth::id())->orderBy('id', 'desc')->first();
		if($folio == null)
		$numfolio = 0;
		else
		$numfolio = $folio -> referencia;
		$numfolio = $numfolio+1;
		
	
	try{	
		//Pago en efectivo OXXO	
		$charge = Conekta_Charge::create(array(
  		'description'=>'Folios Electrónicos',
  		'reference_id'=> 'E_'.$numfolio."_Folios_".Auth::user()->id,
  		'amount'=>$venta,
  		'currency'=>'MXN',
		'cash'=>array(
    	'type'=>'oxxo'
  			),
		
		"details"=> array(
		"name"=> $input->name,
    	"phone"=> $input->telefono,
    	"email"=> $input->email,
		
        "line_items"=> array(
      	array(
        "name" => "Folios",
        "description" => "Folios Electrónicos",
        "unit_price" => 3,
        "quantity" => $request->get('pedido'),
        "sku"=> "a1",
        "category"=> "facturas"
      )
    )
		
		
		)		
		

		));
		
		$compra = [];
		$compra['id_usuario'] = Auth::user()->id;
		$compra['descripcion'] = 'Folios Electrónicos';
		$compra['cantidad'] = $request->get('pedido');
		$compra['tipo_pago'] = 'Efectivo';
		$compra['ultimos4'] = '0000';
		$compra['subtotal'] = $subtotal;
		$compra['iva'] = $iva;
		$compra['total'] = $importe_total;
		$compra['referencia'] = $numfolio;
		$compra['status'] = 'Pendiente';
		
		Compras::create($compra);
		

		$data = [];
		$data['url_bc'] = $charge -> payment_method -> barcode_url;
		$data['barcode'] = $charge -> payment_method -> barcode;
		$data['expires_at'] = date("Y-m-d",$charge -> payment_method -> expires_at);
		$data['amount'] = $charge -> amount/100;
		$data['referencia'] = $numfolio;
		
		$pdf = PDF::loadView('formatos.oxxo',$data);

		return $pdf -> stream();
		
		}catch (Conekta_Error $e){
		return redirect()->back()->withErrors([$e->message_to_purchaser]);
 		//el pago no pudo ser procesado
		}
	
		}else
		{
		//Pago con tarjeta de débito o tarjeta de crédito			
		try{
  		$charge = Conekta_Charge::create(array(
    	"amount"=> $venta,
    	"currency"=> "MXN",
    	"description"=> "Folios Electrónicos",
    	"card"=> $input->customer_key,
    	
		"details"=> array(
		"name"=> $input->name,
    	"phone"=> $input->telefono,
    	"email"=> $input->email,
		
        "line_items"=> array(
      	array(
        "name" => "Folios",
        "description" => "Folios Electrónicos",
        "unit_price" => 3,
        "quantity" => $request->get('pedido'),
        "sku"=> "a1",
        "category"=> "facturas"
      )
    )
		
		
		)		
  		));
		
		//Se captura la referencia
		$numfolio = 0;
		$folio = Compras::where('id_usuario','=',Auth::id())->orderBy('id', 'desc')->first();
		if($folio == null)
		$numfolio = 0;
		else
		$numfolio = $folio -> referencia;
		$numfolio = $numfolio+1;
		
		//Se captura la compra
		$compra = [];
		$compra['id_usuario'] = Auth::user()->id;
		$compra['descripcion'] = 'Folios Electrónicos';
		$compra['cantidad'] = $request->get('pedido');
		$compra['tipo_pago'] = 'Credito';
		$compra['ultimos4'] = $charge->payment_method->last4;
		$compra['subtotal'] = $subtotal;
		$compra['iva'] = $iva;
		$compra['total'] = $importe_total;
		$compra['referencia'] = $numfolio;
		$compra['status'] = 'Pagado';
		
		Compras::create($compra);
		
		//Se agrega el producto
		
		$nuevosFolios = Auth::user()->folios + $request->get('pedido');
		$input = Usuarios_sistema::findOrFail(Auth::id());
		$usuario['folios'] = $nuevosFolios;
		$input -> update($usuario);
		
		
		return redirect('invoices/show');	
		
		
		}catch (Conekta_Error $e){
		return redirect()->back()->withErrors([$e->message_to_purchaser]);
 		//el pago no pudo ser procesado
		}
		}
				
		}else
		{
		 return redirect()->back()->withErrors(['Contraseña Incorrecta']);	
		}	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function buyFormats(BuyRequest $request)
	{
		
		if (Auth::attempt(array('email' => Auth::user()->email, 'password' => $request->pwd)))
		{
			
		$id_usuario = "";
		$input = Usuarios_sistema::findOrFail(Auth::id());
		
		//Calcular importe
		
		
		$item_formato = FormatosCFDI::findOrFail($request->get('formato'));
		
		$total = $item_formato -> importe;		
		$total = $total * 1.16;
		$venta = $total * 100;
		
		$subtotal = $item_formato -> importe;
		$iva = $subtotal * 0.16;
		$importe_total = $subtotal + $iva;
		
		//Calcular importe
	    Conekta::setApiKey("ApiKey"); //Se cambia por la llave privada de Conekta
		Conekta::setLocale('es');
		
		if(Auth::user()->forma_pago == 0)
		{
			
		//Se captura la referencia	
		$numfolio = 0;
		$folio = Compras::where('id_usuario','=',Auth::id())->orderBy('id', 'desc')->first();
		if($folio == null)
		$numfolio = 0;
		else
		$numfolio = $folio -> referencia;
		$numfolio = $numfolio+1;
		
	
	try{	
		//Pago en efectivo OXXO	
		$charge = Conekta_Charge::create(array(
  		'description'=>'Formatos Electrónicos',
  		'reference_id'=> 'F_'.$numfolio."_Formatos_".Auth::user()->id."_".$request->get('formato'),
  		'amount'=>$venta,
  		'currency'=>'MXN',
  		'cash'=>array(
    	'type'=>'oxxo'
  			),
			
	    "details"=> array(
	    "name"=> $input->name,
    	"phone"=> $input->telefono,
    	"email"=> $input->email,
		
        "line_items"=> array(
      	array(
        "name" => "Formatos",
        "description" => "Formatos Electrónicos",
        "unit_price" => $venta,
        "quantity" => 1,
        "sku"=> "a2",
        "category"=> "facturas"
      )
    )
		
		
		)	
			
		));
		
		$compra = [];
		$compra['id_usuario'] = Auth::user()->id;
		$compra['descripcion'] = 'Formato Factura';
		$compra['cantidad'] = 1;
		$compra['tipo_pago'] = 'Efectivo';
		$compra['ultimos4'] = '0000';
		$compra['subtotal'] = $subtotal;
		$compra['iva'] = $iva;
		$compra['total'] = $importe_total;
		$compra['referencia'] = $request->get('formato');
		$compra['status'] = 'Pendiente';
		
		Compras::create($compra);
				
		$data = [];
		$data['url_bc'] = $charge -> payment_method -> barcode_url;
		$data['barcode'] = $charge -> payment_method -> barcode;
		$data['expires_at'] = date("Y-m-d",$charge -> payment_method -> expires_at);
		$data['amount'] = $charge -> amount/100;
		$data['referencia'] = $numfolio;
		
		$pdf = PDF::loadView('formatos.oxxo',$data);
		return $pdf -> stream();
		
		}catch (Conekta_Error $e){
		return redirect()->back()->withErrors([$e->message_to_purchaser]);
 		//el pago no pudo ser procesado
		}
	
		}else
		{
		//Pago con tarjeta de débito o tarjeta de crédito			
		try{
  		$charge = Conekta_Charge::create(array(
    	"amount"=> $venta,
    	"currency"=> "MXN",
    	"description"=> "Formato Factura",
    	"card"=> $input->customer_key,
    	
		"details"=> array(
		"name"=> $input->name,
    	"phone"=> $input->telefono,
    	"email"=> $input->email,
		
        "line_items"=> array(
      	array(
        "name" => "Formatos",
        "description" => "Formatos Electrónicos",
        "unit_price" => $venta,
        "quantity" => 1,
        "sku"=> "a2",
        "category"=> "facturas"
      )
    )
		
		
		)	
		
  		));
		
		//Se captura la referencia
		$numfolio = 0;
		$folio = Compras::where('id_usuario','=',Auth::id())->orderBy('id', 'desc')->first();
		if($folio == null)
		$numfolio = 0;
		else
		$numfolio = $folio -> referencia;
		$numfolio = $numfolio+1;
		
		//Se captura la compra
		$compra = [];
		$compra['id_usuario'] = Auth::user()->id;
		$compra['descripcion'] = 'Formato Factura';
		$compra['cantidad'] = 1;
		$compra['tipo_pago'] = 'Credito';
		$compra['ultimos4'] = $charge->payment_method->last4;
		$compra['subtotal'] = $subtotal;
		$compra['iva'] = $iva;
		$compra['total'] = $importe_total;
		$compra['referencia'] = $request->get('formato');
		$compra['status'] = 'Pagado';
		
		Compras::create($compra);
		
		//Se agrega el producto
		$nuevo = [];
		$nuevo['idusuario'] = Auth::id();
		$nuevo['idformato'] = $request->get('formato');
		FormatosUsuario::create($nuevo);

		
		return redirect('invoices/showFormats');	
		
		
		}catch (Conekta_Error $e){
		return redirect()->back()->withErrors([$e->message_to_purchaser]);
 		//el pago no pudo ser procesado
		}
		}
				
		}else
		{
		 return redirect()->back()->withErrors(['Contraseña Incorrecta']);	
		}		
		
		
	}


public function manageReminderBuy(BuyRequest $request)
	{
						
		if (Auth::attempt(array('email' => Auth::user()->email, 'password' => $request->pwd)))
		{
			
		$id_usuario = "";
		$input = Usuarios_sistema::findOrFail(Auth::id());
		
		//Calcular importe
		
		$total = $request->get('pedido') * 2;
		$total = $total * 1.16;
		$venta = $total * 100;
		
		$subtotal = $request->get('pedido') * 2;
		$iva = $subtotal * 0.16;
		$importe_total = $subtotal + $iva;
		
		//Calcular importe
	    Conekta::setApiKey("ApiKey"); //Se cambia por la llave privada de conekta
		Conekta::setLocale('es');
		
		if(Auth::user()->forma_pago == 0)
		{
			
		//Se captura la referencia	
		$numfolio = 0;
		$folio = Compras::where('id_usuario','=',Auth::id())->orderBy('id', 'desc')->first();
		if($folio == null)
		$numfolio = 0;
		else
		$numfolio = $folio -> referencia;
		$numfolio = $numfolio+1;
		
	
	try{	
		//Pago en efectivo OXXO	
		$charge = Conekta_Charge::create(array(
  		'description'=>'Recordatorios',
  		'reference_id'=> 'R_'.$numfolio."_Recordatorios_".Auth::user()->id,
  		'amount'=>$venta,
  		'currency'=>'MXN',
  		'cash'=>array(
    	'type'=>'oxxo'
  			),
			
		"details"=> array(
		"name"=> $input->name,
    	"phone"=> $input->telefono,
    	"email"=> $input->email,
		
        "line_items"=> array(
      	array(
        "name" => "Alertas",
        "description" => "Alertas Electrónicas",
        "unit_price" => 2,
        "quantity" => $request->get('pedido'),
        "sku"=> "a3",
        "category"=> "alertas"
      )
    )
		
		
		)		
			
		));
		
		$compra = [];
		$compra['id_usuario'] = Auth::user()->id;
		$compra['descripcion'] = 'Recordatorios';
		$compra['cantidad'] = $request->get('pedido');
		$compra['tipo_pago'] = 'Efectivo';
		$compra['ultimos4'] = '0000';
		$compra['subtotal'] = $subtotal;
		$compra['iva'] = $iva;
		$compra['total'] = $importe_total;
		$compra['referencia'] = $numfolio;
		$compra['status'] = 'Pendiente';
		
		Compras::create($compra);
		
		
	
		$data = [];
		$data['url_bc'] = $charge -> payment_method -> barcode_url;
		$data['barcode'] = $charge -> payment_method -> barcode;
		$data['expires_at'] = date("Y-m-d",$charge -> payment_method -> expires_at);
		$data['amount'] = $charge -> amount/100;
		$data['referencia'] = $numfolio;
		
		$pdf = PDF::loadView('formatos.oxxo',$data);
		return $pdf -> stream();
		
		}catch (Conekta_Error $e){
		return redirect()->back()->withErrors([$e->message_to_purchaser]);
 		//el pago no pudo ser procesado
		}
	
		}else
		{
		//Pago con tarjeta de débito o tarjeta de crédito			
		try{
  		$charge = Conekta_Charge::create(array(
    	"amount"=> $venta,
    	"currency"=> "MXN",
    	"description"=> "Recordatorios",
    	"card"=> $input->customer_key,
    	
		"details"=> array(
		"name"=> $input->name,
    	"phone"=> $input->telefono,
    	"email"=> $input->email,
		
        "line_items"=> array(
      	array(
        "name" => "Alertas",
        "description" => "Alertas Electrónicas",
        "unit_price" => 2,
        "quantity" => $request->get('pedido'),
        "sku"=> "a3",
        "category"=> "alertas"
      )
    )
		
		
		)		
		
  		));
		
		//Se captura la referencia
		$numfolio = 0;
		$folio = Compras::where('id_usuario','=',Auth::id())->orderBy('id', 'desc')->first();
		if($folio == null)
		$numfolio = 0;
		else
		$numfolio = $folio -> referencia;
		$numfolio = $numfolio+1;
		
		//Se captura la compra
		$compra = [];
		$compra['id_usuario'] = Auth::user()->id;
		$compra['descripcion'] = 'Recordatorios';
		$compra['cantidad'] = $request->get('pedido');
		$compra['tipo_pago'] = 'Credito';
		$compra['ultimos4'] = $charge->payment_method->last4;
		$compra['subtotal'] = $subtotal;
		$compra['iva'] = $iva;
		$compra['total'] = $importe_total;
		$compra['referencia'] = $numfolio;
		$compra['status'] = 'Pagado';
		
		Compras::create($compra);
		
		//Se agrega el producto
		
		$nuevosFolios = Auth::user()->recordatorios + $request->get('pedido');
		$input = Usuarios_sistema::findOrFail(Auth::id());
		$usuario['recordatorios'] = $nuevosFolios;
		$input -> update($usuario);
		
		
		return redirect('reminders/show');	
		
		
		}catch (Conekta_Error $e){
		return redirect()->back()->withErrors([$e->message_to_purchaser]);
 		//el pago no pudo ser procesado
		}
		}
				
		}else
		{
		 return redirect()->back()->withErrors(['Contraseña Incorrecta']);	
		}	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function buyServices()
	{
		//
	}
	
	public function showBuys()
	{
		$data = [];
		$resultados = Compras::where('id_usuario', '=', Auth::id())->orderBy('id','desc')->paginate(10); 
		$data['resultados'] = $resultados;
		
		return view('shop.show',$data);
	}
	
		public function createInvoice($id)
	{
	   $factura = new Compras_Documento;
       $arregloDocumento = $factura->crearDocumento($id);
	   $xml_sinSello = $factura->crearFactura($arregloDocumento,$id);
	    return redirect('shop/show');
	}
	
		public function printXML($id)
	{		
		$factura = CFDI_Compras::where('id', '=', $id)->first();
		
		$response = Response::make($factura->factura, 200);
		$response->header('Cache-Control', 'public');
		$response->header('Content-Description', 'File Transfer');
		$response->header('Content-Disposition', 'attachment; filename='.$factura->uuid.'.xml');
		$response->header('Content-Transfer-Encoding', 'binary');
		$response->header('Content-Type', 'text/xml');
		return $response;
		}

	public function printPDF($id)
	{
		$data = [];
		$factura = CFDI_Compras::where('id', '=', $id)->first();
		
		$xmlstr = $factura -> factura ; 
		$xml = new SimpleXMLElement($xmlstr);
		
        $data['sello'] =  (string)$xml['sello'];
		$data['folio'] =  (string)$xml['folio'];
		$data['fecha'] =  (string)$xml['fecha'];
		$data['formaDePago'] =  (string)$xml['formaDePago'];
		$data['noCertificado'] =  (string)$xml['noCertificado'];
		$data['NumCtaPago'] =  (string)$xml['NumCtaPago'];
		$data['subTotal'] =  (string)$xml['subTotal'];
		$data['descuento'] =  (string)$xml['descuento'];
		$data['Moneda'] =  (string)$xml['Moneda'];
		$data['total'] =  (string)$xml['total'];
		$data['tipoDeComprobante'] =  (string)$xml['tipoDeComprobante'];
		$data['metodoDePago'] =  (string)$xml['metodoDePago'];
		$data['LugarExpedicion'] =  (string)$xml['LugarExpedicion'];
		$data['observaciones'] =  $factura -> observaciones;
		$data['cadena_original'] =  $factura -> cadena_original;
		
		
		$namespaces = $xml->getNameSpaces(true);
		$hijos = $xml->children($namespaces['cfdi']);
      
		$data['rfc_emisor'] = (string)$hijos->Emisor->attributes()['rfc'];
		$data['nombre_emisor'] = (string)$hijos->Emisor->attributes()['nombre'];
	  
		$data['calle_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['calle'];
		$data['noExterior_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['noExterior'];
		$data['noInterior_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['noInterior'];
		$data['colonia_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['colonia'];
		$data['localidad_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['localidad'];
		$data['municipio_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['municipio'];
		$data['estado_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['estado'];
		$data['pais_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['pais'];
		$data['codigoPostal_emisor'] = (string)$hijos->Emisor->DomicilioFiscal->attributes()['codigoPostal'];
	    
	   	
	   	$data['calle_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['calle'];
		$data['noExterior_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['noExterior'];
		$data['noInterior_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['noInterior'];
		$data['colonia_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['colonia'];
		$data['localidad_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['localidad'];
		$data['municipio_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['municipio'];
		$data['estado_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['estado'];
		$data['pais_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['pais'];
		$data['codigoPostal_ExpedidoEn'] = (string)$hijos->Emisor->ExpedidoEn->attributes()['codigoPostal'];
	   
	   $data['regimenFiscal'] = (string)$hijos->Emisor->RegimenFiscal->attributes()['Regimen'];
	   
	   
	   	$data['rfc_receptor'] = (string)$hijos->Receptor->attributes()['rfc'];
		$data['nombre_receptor'] = (string)$hijos->Receptor->attributes()['nombre'];
	  
		$data['calle_receptor'] = (string)$hijos->Receptor->Domicilio->attributes()['calle'];
		$data['noExterior_receptor'] = (string)$hijos->Receptor->Domicilio->attributes()['noExterior'];
		$data['colonia_receptor'] = (string)$hijos->Receptor->Domicilio->attributes()['colonia'];
		$data['estado_receptor'] = (string)$hijos->Receptor->Domicilio->attributes()['estado'];
		$data['pais_receptor'] = (string)$hijos->Receptor->Domicilio->attributes()['pais'];
		$data['codigoPostal_receptor'] = (string)$hijos->Receptor->Domicilio->attributes()['codigoPostal'];
	   	
		$p_conceptos = [];
		foreach ($hijos->Conceptos->Concepto as $concepto) {
			
		$partidas = [];			
		$partidas['cantidad'] = (string)$concepto->attributes()['cantidad'];
		$partidas['unidad'] = (string)$concepto->attributes()['unidad'];
		$partidas['descripcion'] = (string)$concepto->attributes()['descripcion'];
		$partidas['valorUnitario'] = (string)$concepto->attributes()['valorUnitario'];
		$partidas['noIdentificacion'] = (string)$concepto->attributes()['noIdentificacion'];
		$partidas['importe'] = (string)$concepto->attributes()['importe'];
		$p_conceptos[] = $partidas;	
		}
		
		$data['conceptos'] = $p_conceptos;    
		
	    $p_traslados = [];
		foreach ($hijos->Impuestos->Traslados->Traslado as $concepto) {
			
		$partidas = [];			
		$partidas['impuesto'] = (string)$concepto->attributes()['impuesto'];
		$partidas['importe'] = (string)$concepto->attributes()['importe'];
		$p_traslados[] = $partidas;	
		}
				
		$data['traslados'] = $p_traslados;    
		
		
		$total_facturado = number_format($factura -> total_facturado,6,'.', '');
        $total_facturado = str_pad($total_facturado,17,"0",STR_PAD_LEFT);
        $cadena_reporte = "?re=".$factura -> emisor."&rr=".$factura -> receptor."&tt=".$total_facturado."&id=".$factura -> uuid;
		
		 
		
		$pac = $hijos->Complemento->children($namespaces['tfd']);		
		$data['uuid'] = (string)$pac->TimbreFiscalDigital->attributes()['UUID'];
		$data['noCertificadoSAT'] = (string)$pac->TimbreFiscalDigital->attributes()['noCertificadoSAT'];
		$data['FechaTimbrado'] = (string)$pac->TimbreFiscalDigital->attributes()['FechaTimbrado'];
		$data['selloSAT'] = (string)$pac->TimbreFiscalDigital->attributes()['selloSAT']; 
		

		
		$data['cadenaReporte'] = $cadena_reporte;

		
		$pdf = PDF::loadView('formatos.standard',$data);
		return $pdf -> stream();
	}

}
