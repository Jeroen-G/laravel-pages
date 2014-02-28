<?php namespace JeroenG\LaravelPages;

use \Mockery as m;
use JeroenG\LaravelPages\LaravelPages;

/**
 * This is for testing the package
 *
 * @package LaravelPages
 * @subpackage Tests
 * @author 	JeroenG
 * 
 **/
class LaravelPagesTest extends \PHPUnit_Framework_TestCase
{

	public function testPageExists()
	{
		m::mock('Illuminate\Database\Eloquent\Model')
		$LPages = new LaravelPages();
		$output = $LPages->PageExists('hello-world');
		$this->assertEquals($output, true);
	}
}