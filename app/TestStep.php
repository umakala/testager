<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TestStep extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'teststeps';

	protected $primaryKey = 'ts_id';

	/**
     * The testcases that belong to the teststep.
     */
    public function testcases()
    {
        return $this->belongsToMany('App\TestCase');
    }
    public function testprojects()
    {
        return $this->belongsToMany('App\TestProject');
    }
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['ts_id', 'ts_name','description', 'execution_format', 'expected_result', 'status', 'tc_id', 'tp_id', 'created_by', 'seq_no'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
}
