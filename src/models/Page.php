<?php namespace JeroenG\LaravelPages;

/**
 * This is the page model.
 *
 * @package LaravelPages
 * @subpackage Models
 * @author 	JeroenG
 * 
 **/
class Page extends \Eloquent {

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
	 * Protecting pages from accidentally getting deleted.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;
}