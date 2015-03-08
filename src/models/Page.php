<?php namespace JeroenG\LaravelPages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is the page model.
 *
 * @package LaravelPages
 * @subpackage Models
 * @author 	JeroenG
 * 
 **/
class Page extends Model {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
	 * The primary key
	 *
	 * @var string
	 **/
	protected $primaryKey = 'page_id';

	/**
	 * This is for the SoftDeleting functionality.
	 *
	 * @var boolean
	 */
    protected $dates = ['deleted_at'];
}