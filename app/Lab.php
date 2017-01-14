<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'labs';

	protected $primaryKey = 'tl_id';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['tl_id', 'tp_id', 'tf_id', 'tsc_id' ,'tc_id', 'bug_id', 'tc_status', 'execution_type', 'executed_by', 'created_at', 'updated_at', '	execution_result', 'checkpoint_result', 'executed_filename'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
