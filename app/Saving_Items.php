<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Saving_Items extends Model {

	 protected $fillable = [
	 
	 'idprestamo',
	 'idusuario',
	 'idcliente',
	 'fechacobro',
	 'parcialidad',
	 'abonado',
	 'status'	 
	 ];
	 
	protected $table = 'partidas_ahorro';

}
