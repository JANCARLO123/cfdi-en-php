<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model {

    protected $fillable = [
	 
	 'idusuario',
	 'idcliente',
	 'plazo',
	 'fechaprimerpago',
	 'totalprestado',
	 'status',
	 'tipo',
	 'tipo_cobro',
	 'estado_cobro',
	 
	 ];
	 
	protected $table = 'ahorro';

}
