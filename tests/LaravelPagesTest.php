<?php

use JeroenG\LaravelPages\LaravelPages;

/**
 * This is for testing the package
 *
 * @package LaravelPages
 * @subpackage Tests
 * @author 	JeroenG
 * 
 **/
class LaravelPagesTest extends TestCase
{

    /**
     * The LaravelPages instance
     * @var object
     */
    protected $pages;
    
    /**
     * Setup DB before each test.
     *
     * @return void  
     */
    public function setUp()
    { 
        parent::setUp();

        $this->app['config']->set('database.default','sqlite'); 
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $this->migrate();

        $this->pages = new LaravelPages();
    }

    /**
     * run package database migrations
     *
     * @return void
     */
    public function migrate()
    { 
        $classFinder = $this->app->make('Illuminate\Filesystem\ClassFinder');
        
        $path = realpath(__DIR__ . "/../migrations");
        $files = glob($path.'/*');

        foreach($files as $file)
        {
            require_once $file;
            $migrationClass = $classFinder->findClass($file);

            (new $migrationClass)->up();
        }
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
		$output = $this->pages->addPage($page_title, $page_content);
		$this->assertTrue($output);
	}

	/**
     * Test if the page does exists.
     *
     * @test
     */
	public function testPageExists()
	{
        $this->dummy();
		$output = $this->pages->PageExists('hello-world');
		$this->assertTrue($output);
	}

	/**
     * Test if the page does NOT exists.
     *
     * @test
     */
	public function testPageNotExists()
	{
		$output = $this->pages->PageExists('hello-universe');
		$this->assertFalse($output);
	}

	/**
     * Test getting the page data based on the slug.
     *
     * @test
     */
    public function testGetPage()
    {
        $this->dummy();
        $output = $this->pages->getPage('hello-world');
        $this->assertContains('Dummy Content', $output->page_content);
    }

    /**
     * Test getting the page data based on the ID.
     *
     * @test
     */
    public function testGetPageById()
    {
        $this->dummy();
        $output = $this->pages->getPageById(1);
        $this->assertContains('Dummy Content', $output->page_content);
    }

    /**
     * Test getting the page data based on the slug and including trashed pages.
     *
     * @test
     */
    public function testGetTrashedPage()
    {
        $this->dummy();
        $this->pages->deletePage(1);
        $output = $this->pages->getPage('hello-world', true);
        $this->assertContains('Test', $output->page_title);
    }

    /**
     * Test getting the page data based on the ID and including trashed pages.
     *
     * @test
     */
    public function testGetTrashedPageById()
    {
        $this->dummy();
        $this->pages->deletePage(1);
        $output = $this->pages->getPageById(1, true);
        $this->assertContains('Test', $output->page_title);
    }

	/**
     * Test getting the page id.
     *
     * @test
     */
	public function testGetPageId()
	{
        $this->dummy();
		$output = $this->pages->getPageId('hello-world');
		$this->assertEquals(1, $output);
	}

	/**
     * Test getting the id of a soft-deleted page.
     *
     * @test
     */
    public function testGetDeletedPageId()
    {
        $this->dummy();
        $this->pages->deletePage(1);
        $output = $this->pages->getPageId('hello-world');
        $this->assertEquals(1, $output);
    }

    /**
     * Test restoring a page.
     *
     * @test
     */
    public function testRestorePage()
    {
        // Deleting page
        $this->dummy();
        $this->pages->deletePage(1);
        $output = $this->pages->getPageById(1);
        $this->assertNull($output);

        // Restoring page
        $this->pages->restorePage(1);
        $output2 = $this->pages->getPageById(1);
        $this->assertEquals(1, $output2->page_id);
    }

	/**
     * Test getting the id of a force-deleted page, because it shouldn't work.
     *
     * @test
     */
	public function testGetForceDeletedPageId()
	{
        $this->dummy();
		$this->setExpectedException('ErrorException');
		$this->pages->deletePage(1, true);
		$output = $this->pages->getPageId(1);
	}

    /**
     * Test updating the page.
     *
     * @test
     */
    public function testUpdatePage()
    {
        $this->dummy();
        $page = $this->pages->getPageById(1);

        $id = 1;
        $title = "Test";
        $content = "New Dummy Content";
        $slug = "hello-world";

        $this->pages->updatePage($id, $title, $content, $slug);

        $output = $this->pages->getPage('hello-world');
        $this->assertContains('New Dummy Content', $output->page_content);
    }

    public function dummy()
    {
        $this->pages->addPage('Test', 'Dummy Content', 'hello-world');
    }
}