<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Defect extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'defects';

	protected $primaryKey = 'id';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'defect_id' , 'defect_status', 'description' ,'tp_id', 'tf_id', 'ts_id' ,'tc_id', 'reported_by', 'reported_by_name', 'release_version', 'created_at' ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
