<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TestScenario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'testscenarios';

	protected $primaryKey = 'tsc_id';

	/**
     * The testscenarios that belong to the teststep.
     */
    public function testfunctionalities()
    {
        return $this->belongsToMany('App\TestFunctionality');
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
	protected $fillable = ['tsc_id', 'tsc_name','description', 'expected_result', 'status', 'tf_id', 'tp_id', 'created_by', 'scenario_brief', 'seq_no'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
