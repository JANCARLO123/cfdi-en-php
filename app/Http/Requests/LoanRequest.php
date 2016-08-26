<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoanRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			
			'idcliente' => 'required',
			'plazo' => 'required',
			'fechaprestamo' => 'required',
			'fechaprimerpago' => 'required',
			'totalprestado' => 'required',
			'ahorro' => 'required',
			'rendimiento' => 'required'
			
		];
	}

}
