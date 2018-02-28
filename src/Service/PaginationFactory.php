<?php

namespace App\Service;

use App\Service\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
* Pagination Factory 
*/
class PaginationFactory
{
	private $router;

	function __construct(RouterInterface $router)
	{
		$this->router = $router;
	}

	/**
	 * Use the Paginator class to paginate items
	 *
	 * @return array
	 *
	 * @param array $items
	 * @param int $itemsPerPage
	 * @param Request $request Client request
	 * @param $route requested page route name to generate 'rel' links
	 **/
	public function createCollection($items, $itemsPerPage = 10, Request $request, $route, array $routeParams = array())
	{
		$paginator = new Paginator(count($items), $itemsPerPage);
		$pageNumber = $request->query->get('page', 1);
		$routeParams = array_merge($routeParams, $request->query->all());
		$createLinkUrl = function($pageNumber) use ($route, $routeParams){
		  return $this->router->generate($route, array_merge(
		    $routeParams,
		    array('page' => $pageNumber)
		  ));
		};
		$paginator->setPageIndex($pageNumber);
		$paginator->addLink('self', $createLinkUrl($pageNumber));
		$paginator->addLink('first', $createLinkUrl(1));
		$paginator->addLink('last', $createLinkUrl($paginator->getPageCount()));
		if (!$paginator->isLast()) {
		  $paginator->addLink('next', $createLinkUrl($paginator->getNextPage()));
		}
		if (!$paginator->isFirst()) {
		  $paginator->addLink('previous', $createLinkUrl($paginator->getPreviousPage()));
		}
		$pageDetails = $paginator->getPageDetails();
		// var_dump($pageDetails);
		$items = array_slice($items, $paginator->getOffset(), $pageDetails['count']);
		  
		return array_merge(
		    array('items' => $items),
		    $pageDetails
		);
	}
}