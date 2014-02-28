<?php namespace JeroenG\LaravelPages;

use JeroenG\LaravelPages\Page;

class LaravelPages {

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

	public function getPage($slug)
	{
		$query = Page::where('page_slug', '=', $slug)->first();
		return $query->toArray();
	}

	public function getPageId($slug)
	{
		$query = Page::where('page_slug', '=', $slug)->withTrashed()->select('page_id')->first();
		return $query->page_id;
	}

	public function createSlug($slugify_this)
	{
		$slugify = new \Cocur\Slugify\Slugify();
		return $slugify->slugify($slugify_this);
	}

	public function addPage($page_title, $page_content, $custom_slug = null)
	{
		$newPage = new Page;
		$newPage->page_title = $page_title;
		$newPage->page_content = $page_content;
		if(!is_null($custom_slug))
		{
			$newPage->page_slug = $this->createSlug($custom_slug);
		}
		else
		{
			$newPage->page_slug = $this->createSlug($page_title);
		}

		return $newPage->save();
	}

	public function updatePage($page_id, $page_title, $page_content, $page_slug)
	{
		$page = Page::find($page_id);
		$page->page_title = $page_title;
		$page->page_content = $page_content;
		$page->page_slug = $this->createSlug($page_slug);
		$page->touch();
		return $page->save();
	}

	public function deletePage($page_id, $forceDelete = false)
	{
		$page = Page::find($page_id);

		if($forceDelete)
		{
			return $page->forceDelete($page_id);
		}
		else
		{
			return $page->delete($page_id);
		}
	}

	public function restorePage($page_id)
	{
		$page = Page::withTrashed()->find($page_id);
		return $page->restore($page_id);
	}
}