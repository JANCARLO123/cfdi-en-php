<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	 protected $fillable = [
	 
	 'idusuario',
	 'idcliente',
	 'plazo',
	 'fechaprestamo',
	 'fechaprimerpago',
	 'totalprestado',
	 'ahorro',
	 'rendimiento',
	 'status',
	 'tipo_cobro',
	 'estado_cobro',
	 
	 ];
	 
	protected $table = 'prestamo';

}
