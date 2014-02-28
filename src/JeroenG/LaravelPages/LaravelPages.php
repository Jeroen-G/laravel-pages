<?php namespace JeroenG\LaravelPages;

class LaravelPages {

	/**
	 * The page model
	 *
	 * @var \JeroenG\LaravelPages\Page
	 **/
	protected $page;

	/**
	 * Instantiate the class
	 *
	 * @return void
	 **/
	public function __construct()
	{
		$this->page = \App::make('JeroenG\LaravelPages\Page');
	}

	public function pageExists($slug)
	{
		$count = $this->page->where('page_slug', '=', $slug)->count();

		if ($count == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function getPage($slug)
	{
		$query = $this->page->where('page_slug', '=', $slug)->get();
		return $query->toArray();
	}

	public function createSlug($page_title)
	{
		$slugify = new \Cocur\Slugify\Slugify();
		return $slugify->slugify($page_title);
	}
}