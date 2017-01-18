<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Execution extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'executions';

	protected $primaryKey = 'e_id';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['e_id', 'tp_id', 'ts_id' ,'tc_id', 'scroll', 'resource_id', 'text', 'content_desc','class', 'index', 'sendkey', 'screenshot', 'checkpoint', 'wait', 'executed_by', '	executed_by_name', 'execution_result', 'checkpoint_result',  'created_at', 'updated_at', 'seq_no', 'tl_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
