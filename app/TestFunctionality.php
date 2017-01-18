<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TestFunctionality extends Model {

	//
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'testfunctionalities';

	protected $primaryKey = 'tf_id';
	

	/**
     * The testprojects belong to the testfunctionality.
     */
    public function testprojects()
    {
        return $this->belongsToMany('App\TestProject');
    }
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['tf_id', 'tf_name','description','tp_id', 'created_by'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
