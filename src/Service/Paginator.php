<?php

namespace App\Service;


/**
* Pagination Helper Service
*/
class Paginator
{
	private $collection;

	private $itemsPerPage;

	private $pageIndex;

	private $_links = array();

	public function __construct($collection, $itemsPerPage)
	{
		$this->collection = $collection;
		$this->itemsPerPage = $itemsPerPage;
	}

	public function addLink($ref, $url)
	{
		$this->_links[$ref] = $url;
	}

	/**
	 * Get total number of items
	 * 
	 * @return int
	 */
	public function itemCount()
	{
		return $this->collection;
	}

	/**
	 * Number of items on last page
	 * 
	 * @return int
	 */
	public function lastPageItemCount()
	{
		return $this->collection%$this->itemsPerPage ? $this->collection%$this->itemsPerPage : $this->itemsPerPage;
	}

	/**
	 * Set Page Number
	 * 
	 * @param int $index
	 **/
	public function setPageIndex($index)
	{
		$this->pageIndex = $index;
	}

	/**
	 * Set the maximum number of items per page
	 * 
	 * @param int $max
	 */
	public function setItemsPerPage($max)
	{
		$this->itemsPerPage = $max;
	}

	/**
	 * Items per page
	 *
	 * @return void
	 **/
	public function getItemsPerPage()
	{
		return $this->itemsPerPage;
	}

	/**
	 * Return the next page number
	 * 
	 * @return int
	 */
	public function getNextPage()
	{
		return $this->pageIndex+1;
	}

	/**
	 * Return the previous page number
	 * 
	 * @return int
	 */
	public function getPreviousPage()
	{
		return $this->pageIndex-1;
	}

	/**
	 * Return offset for current page index
	 *
	 * @return int
	 **/
	public function getOffset()
	{
		if (($this->pageIndex > $this->getPageCount()) || $this->pageIndex < 1) {
			return 0;
		}

		return ($this->pageIndex-1)*$this->itemsPerPage;
	}

	/**
	 * Number of Pages
	 * 
	 * @return int
	 */
	public function getPageCount()
	{
		return ceil($this->collection/$this->itemsPerPage);
	}

	/**
	 * Is this the first page
	 * 
	 * @return boolean
	 */
	public function isFirst()
	{
		return $this->pageIndex === 1;
	}

	/**
	 * Is this the last page
	 * 
	 * @return boolean
	 */
	public function isLast()
	{
		return $this->pageIndex == $this->getPageCount();
	}

	/**
	 * Number of items on current page
	 * 
	 * @return int
	 */
	public function pageItemCount()
	{
		return $this->isLast() ? $this->lastPageItemCount() : $this->itemsPerPage;
	}

	/**
	 * Return array containing page details
	 * 
	 * @return array
	 */
	public function getPageDetails()
	{
		return array(
			'_links.previous' => $this->_links['previous'] ?? $this->_links['self'],
			'_links.next' => $this->_links['next'] ?? $this->_links['self'],
			'self' => $this->_links['self'],
			'count' => $this->pageItemCount(),
			'total' => $this->collection,
			'pages' => $this->getPageCount(),
			'_links.first' => $this->_links['first'],
			'_links.last' => $this->_links['last']
		);
	}
}