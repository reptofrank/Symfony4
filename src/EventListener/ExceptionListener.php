<?php

namespace App\EventListener;

use App\Service\ApiProblem;
use App\Service\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Catch Exception events for Api
 */
class ExceptionListener
{

  public function onKernelException(GetResponseForExceptionEvent $event)
  {
    $exception = $event->getException();

    $path = $event->getRequest()->getPathInfo();
    if (strpos($path, '/api') !== 0) {
      return;
    }

    if ($exception instanceof ApiException) {
      $apiProblem = $exception->getApiProblem();
      $statusCode = $apiProblem->getStatusCode();
    }else {
      $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
      $apiProblem = new ApiProblem($statusCode);
    }

    $response = new JsonResponse(
      $apiProblem->toArray(),
      $statusCode,
      array(
        'content-type' => 'application/problem+json'
      )
    );
    $event->setResponse($response);
  }
}
