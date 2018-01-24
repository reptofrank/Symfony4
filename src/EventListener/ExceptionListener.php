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
    if (strpos($path, '/api') !== 0 || ! $exception instanceof ApiException) {
      return;
    }

    $response = new JsonResponse(
      $exception->getApiProblem()->toArray(),
      $exception->getApiProblem()->getStatusCode(),
      array(
        'content-type' => 'application/problem+json'
      )
    );


    // if ($exception instanceof HttpExceptionInterface) {
    //   $response->setStatusCode($exception->getStatusCode());
    //   $response->headers->replace($exception->getHeaders());
    // }else {
    //   $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    // }

    $event->setResponse($response);
  }
}
