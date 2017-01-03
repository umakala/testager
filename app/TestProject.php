<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TestProject extends Model {

	//
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'testprojects';

	protected $primaryKey = 'tp_id';
	

	/**
     * The testprojects belong to the testfunctionality.
     */
    public function testfunctionalities()
    {
        return $this->belongsToMany('App\testfunctionality');
    }

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['tp_id', 'tp_name', 'release', 'created_by'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
