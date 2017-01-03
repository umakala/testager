<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'news';

	protected $primaryKey = 'news_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['news_id', 'title', 'text', 'image', 'reporter_email'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['remember_token'];


}
