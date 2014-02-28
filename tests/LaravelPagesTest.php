<?php namespace JeroenG\LaravelPages;

use JeroenG\LaravelPages\LaravelPages;

/**
 * This is for testing the package
 *
 * @package LaravelPages
 * @subpackage Tests
 * @author 	JeroenG
 * 
 **/
class LaravelPagesTest extends \Orchestra\Testbench\TestCase
{

	/**
     * Get package providers.
     * 
     * At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @return array
     */
	protected function getPackageProviders()
	{
	    return array('JeroenG\LaravelPages\LaravelPagesServiceProvider');
	}

    /**
     * Get package aliases.
     * 
     * In a normal app environment these would be added to
     * the 'aliases' array in the config/app.php file.  If your package exposes an
     * aliased facade, you should add the alias here, along with aliases for
     * facades upon which your package depends, e.g. Cartalyst/Sentry
     *
     * @return array
     */
	protected function getPackageAliases()
	{
	    return array(
	        'LPages' => 'JeroenG\LaravelPages\Facades\LaravelPages',
	    );
	}

	/**
     * Define environment setup.
     *
     * @param  Illuminate\Foundation\Application    $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        $app['path.base'] = __DIR__ . '/../src';

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));
    }

	/**
     * Setup the test environment.
     *
     * @return void
     */
	public function setUp()
	{
		parent::setUp();

		$artisan = $this->app->make('artisan');
		$artisan->call('migrate', array(
            '--database' => 'testbench',
            '--path'     => 'migrations',
        ));

        \DB::table('pages')->insert(array(
            'page_title'    =>	'Hello World',
            'page_content'  =>	'This is for testing',
            'page_slug'		=>	'hello-world',
            'created_at'	=>	'2014-01-01 00:00:00',
            'updated_at'	=>	'2014-01-01 00:00:00',
        ));
	}

	/**
     * Test adding a new page.
     *
     * @test
     */
	public function testAddPage()
	{
		$page_title = "Hello Europe";
		$page_content = "This is the content for another page";
		$output = \LPages::addPage($page_title, $page_content);
		$this->assertTrue($output);
	}

	/**
     * Test if the page does exists.
     *
     * @test
     */
	public function testPageExists()
	{
		$output = \LPages::PageExists('hello-world');
		$this->assertTrue($output);
	}

	/**
     * Test if the page does NOT exists.
     *
     * @test
     */
	public function testPageNotExists()
	{
		$output = \LPages::PageExists('hello-universe');
		$this->assertFalse($output);
	}

	/**
     * Test getting the page data.
     *
     * @test
     */
	public function testGetPage()
	{
		$output = \LPages::getPage('hello-world');
		$this->assertEquals(7, count($output));
		$this->assertContains('Hello World', $output);
	}

	/**
     * Test getting the page id.
     *
     * @test
     */
	public function testGetPageId()
	{
		$output = \LPages::getPageId('hello-world');
		$this->assertEquals(1, $output);
	}

	/**
     * Test getting the id of a soft-deleted page. Also tests restoring.
     *
     * @test
     */
	public function testGetDeletedPageId()
	{
		\LPages::deletePage(1);
		$output = \LPages::getPageId('hello-world');
		\LPages::restorePage(1);
		$this->assertEquals(1, $output);
	}

	/**
     * Test getting the id of a force-deleted page, because it shouldn't work.
     *
     * @test
     */
	public function testGetForceDeletedPageId()
	{
		$this->setExpectedException('ErrorException');
		\LPages::deletePage(1, true);
		$output = \LPages::getPageId('hello-world');
	}
}