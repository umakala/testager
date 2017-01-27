<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ScenarioLab extends Model {

	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'scenariolabs';

	protected $primaryKey = 'scl_id';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['scl_id', 'tp_id', 'tf_id', 'tsc_id', 'result', 'execution_type', 'executed_by', 'created_at', 'updated_at'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
}
