<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Api Http Exception
 */
class ApiException extends HttpException
{
  /**
   * @var ApiProblem
   */
  var $apiProblem;

  function __construct(ApiProblem $apiProblem, \Exception $previous = null, array $headers = array(), $code = 0)
  {
    $this->apiProblem = $apiProblem;
    parent::__construct(
      $this->apiProblem->getStatusCode(),
      $this->apiProblem->getTitle(),
      $previous,
      $headers,
      $code
    );
  }

  /**
   * @return ApiProblem
   */
  public function getApiProblem(): ApiProblem
  {
    return $this->apiProblem;
  }

  public function getTitle()
  {
    return $this->apiProblem->getTitle();
  }
}
