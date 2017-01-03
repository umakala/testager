<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'testcases';

	protected $primaryKey = 'tc_id';
	
	/**
     * The testscenarios that belong to the teststep.
     */
    public function testscenarios()
    {
        return $this->belongsToMany('App\TestScenario');
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
	protected $fillable = ['tc_id', 'tc_name','description', 'expected_result', 'status', 'tsc_id', 'tp_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
}
