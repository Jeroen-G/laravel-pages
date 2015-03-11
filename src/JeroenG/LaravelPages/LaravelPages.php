<?php namespace JeroenG\LaravelPages;

use JeroenG\LaravelPages\Page;

/**
 * This class is the core of the package. Everything is handles through here, although you might always use the Facade 'LPages'.
 *
 * @package LaravelPages
 * @author 	JeroenG
 * 
 **/
class LaravelPages {

	/**
	 * Checks if a page exists in the database.
	 *
	 * @param string $slug The slug to search for in the database.
	 * @return boolean Returns true if the page exists, false otherwise.
	 **/
	public function pageExists($slug)
	{
		$count = Page::where('page_slug', '=', $slug)->count();

		if ($count == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Gets all the data of the page from the database, based on the slug.
	 *
	 * @param string $slug The slug to search for in the database.
	 * @param boolean $trashed Include trashed (soft deleted) pages?
	 * @return array The data such as title, content and publishing date in an array.
	 **/
	public function getPage($slug, $trashed = false)
	{
		if($trashed)
		{
			return Page::withTrashed()->where('page_slug', '=', $slug)->first();
		}
		return Page::where('page_slug', '=', $slug)->first();
	}

	/**
	 * Gets all the data of the page from the database, based on the ID.
	 *
	 * @param string $id The id to search for in the database.
	 * @param boolean $trashed Include trashed (soft deleted) pages?
	 * @return array The data such as title, content and publishing date in an array.
	 **/
	public function getPageById($id, $trashed = false)
	{
		if($trashed)
		{
			return Page::withTrashed()->find($id);
		}
		return Page::find($id);
	}

	/**
	 * Gets only the id of the page that belongs to the given slug.
	 *
	 * @param string $slug The slug to search for in the database.
	 * @return int The id of the page.
	 **/
	public function getPageId($slug)
	{
		$query = Page::where('page_slug', '=', $slug)->withTrashed()->select('page_id')->first();
		return $query->page_id;
	}

	/**
	 * Creates a slug.
	 *
	 * @param string $slugify_this The piece of text to transform into a slug.
	 * @return string A safe slug.
	 **/
	public function createSlug($slugify_this)
	{
		$slugify = new \Cocur\Slugify\Slugify();
		return $slugify->slugify($slugify_this);
	}

	/**
	 * Adds a page to the database.
	 *
	 * @param string $page_title The title of the page.
	 * @param text $page_content The content of the page.
	 * @param string|null $custom_slug A custom slug, if not provided the page title is slugified.
	 * @return void The page is saved.
	 **/
	public function addPage($page_title, $page_content, $custom_slug = null)
	{
		$newPage = new Page;
		$newPage->page_title = $page_title;
		$newPage->page_content = $page_content;
		if(is_null($custom_slug) or empty($custom_slug))
		{
			$newPage->page_slug = $this->createSlug($page_title);
		}
		else
		{
			$newPage->page_slug = $this->createSlug($custom_slug);
		}

		return $newPage->save();
	}

	/**
	 * Updates an existing page.
	 *
	 * @param int $page_id The id of the existing page.
	 * @param string $page_title The (changed) title of the page.
	 * @param text $page_content The (changed) content of the page.
	 * @param string $page_slug The (changed) slug of the page.
	 * @return void The page is saved.
	 **/
	public function updatePage($page_id, $page_title, $page_content, $page_slug)
	{
		$page = Page::find($page_id);
		$page->page_title = $page_title;
		$page->page_content = $page_content;
		$page->page_slug = $this->createSlug($page_slug);
		$page->touch();
		return $page->save();
	}

	/**
	 * Deletes a page, possibly even with force.
	 *
	 * If $forceDelete is set to true, the page will be removed from the database (for ever).
	 * If kept at false, the page will get a 'deleted_at' value and does not show until restored.
	 *
	 * @param int $page_id The id of the page.
	 * @param boolean $forceDelete Whether to really remove the page from the database or not.
	 * @return void The page is deleted.
	 **/
	public function deletePage($page_id, $forceDelete = false)
	{
		$page = Page::withTrashed()->find($page_id);

		if($forceDelete)
		{
			return $page->forceDelete($page_id);
		}
		else
		{
			return $page->delete($page_id);
		}
	}

	/**
	 * Restores a previously soft-deleted page.
	 *
	 * The id of the page can be retrieved with the getPageId() function.
	 *
	 * @param int $page_id The id of the page.
	 * @return void The page is back!
	 **/
	public function restorePage($page_id)
	{
		$page = Page::withTrashed()->find($page_id);
		return $page->restore($page_id);
	}
}
