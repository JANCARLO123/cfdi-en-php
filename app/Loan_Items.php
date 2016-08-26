<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan_Items extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	 protected $fillable = [
	 
	 'idprestamo',
	 'idusuario',
	 'idcliente',
	 'fechacobro',
	 'parcialidad',
	 'abonado',
	 'status'	 
	 ];
	 
	protected $table = 'partidas_prestamo';

}
