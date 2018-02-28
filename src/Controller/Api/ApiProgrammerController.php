<?php

namespace App\Controller\Api;

use App\Entity\Programmer;
use App\Form\ProgrammerType;
use App\Service\ApiProblem;
use App\Service\ApiException;
use App\Service\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Api Controller
 */
class ApiProgrammerController extends Controller
{

  /**
   * @param $mixed $error
   */
  private function handleValidate($error)
  {
    $apiProblem = new ApiProblem(
      400,
      ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT
    );
    // $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
    $apiProblem->extraData('errors', $error);
    throw new ApiException($apiProblem);
    // $errorResponse = $apiProblem->toArray();
    // return $this->json($errorResponse, $apiProblem->getStatusCode(), array('content-type' => 'application/problem+json'));
  }

  /**
   * @param Request $request
   * @Route("/api/programmers", name="api_register_programmer")
   * @Method("POST")
   */
  public function newAction(Request $request)
  {
    $programmer = new Programmer();
    $body = $request->getContent();
    $data = json_decode($body, true);
    $form = $this->createForm(ProgrammerType::class, $programmer);
    $form->submit($data);
    // var_dump($data);die;
    // $this->handleRequest($request, $programmer);
    $error = $this->get('app.entity_validator')->validate($programmer);
    if ($error) {
      return $this->handleValidate($error);
    }

    $em = $this->getDoctrine()->getManager();
    $em->persist($programmer);
    $em->flush();
    return $this->json($programmer, 201, ['Location' => $this->generateUrl('api_programmer_show', ['nickname' => $programmer->getNickname()])]);
  }

  /**
   * @param Request $request
   * @param Programmer $programmer
   */
  public function handleRequest(Request $request, Programmer $programmer)
  {
    $data = json_decode($request->getContent(), true);
    if ($data === null) {
      $apiProblem = new ApiProblem(
        400,
        ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT
      );
      throw new ApiException($apiProblem);
    }
    $isNew = !$programmer->getId();

    $apiProperties = array('avatarNumber', 'tagLine', 'nickname');
    if ($isNew) {
      $apiProperties[] = 'nickname';
    }
    foreach ($apiProperties as $property) {
      $func = 'set'.ucfirst($property);
      $programmer->$func(isset($data[$property]) ? $data[$property] : null);
    }
  }

  /**
   * @Route("/api/programmers/{nickname}", name="api_programmer_show")
   * @param int $nickname
   * @return return JsonResponse
   * @Method("GET")
   */
  public function showAction($nickname)
  {
    $em = $this->getDoctrine()->getManager();
    $programmer = $em->getRepository(Programmer::class)->findOneBy(['nickname' => $nickname]);
    if (!$programmer) {
      $apiProblem = new ApiProblem(
        404,
        ApiProblem::TYPE_INVALID_REQUEST_URI
      );
      $apiProblem->extraData('details', sprintf('The programmer %s doesnt exist', $nickname));
      throw new ApiException($apiProblem);
    }
    return $this->json($programmer);
  }

  /**
   * Get all Programmers
   * @Route("/api/programmers", name="show_all")
   * @return Programmer[] array
   * @Method("GET")
   */
  public function allAction(Request $request)
  {
    $filter = $request->query->get('filter');
    $programmers = $this->getDoctrine()->getRepository(Programmer::class)->findAllOr($filter);
    $route = 'show_all';
    $routeParams = array();
    $response = $this->get('app.pagination_factory')->createCollection($programmers, 10, $request, $route, $routeParams);
    return $this->json($response);
  }

  /**
   * Search for programmers matching search query
   *
   * @Route("/api/programmers/{filter}", name="search_programmers")
   * @Method("GET")
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  // public function searchAction(Request $request, $filter)
  // {
  //   $result = $this->getDoctrine()->getRepository(Programmer::class)->findBySomething($filter);
  //   $route = 'search_programmers';
  //   $routeParams = array('filter');
  // }

  /**
   * @Route("/api/programmers/{nickname}", name="update_programmer")
   * @Method("PUT")
   * @param Request $request
   * @param string $nickname
   * @return JsonResponse
   */
  public function updateAction(Request $request, $nickname)
  {

    $em = $this->getDoctrine()->getManager();
    $programmer = $em->getRepository(Programmer::class)
                        ->findOneBy(['nickname' => $nickname]);
    if (!$programmer) {
      // $apiProblem = new ApiProblem(404, ApiProblem::TYPE_INVALID_REQUEST_URI);
      // $apiProblem->extraData('details', sprintf('The programmer %s doesnt exist', $nickname));
      
      throw $this->createNotFoundException(sprintf('The programmer %s doesn\'t exist', $nickname));
    }
    $this->handleRequest($request, $programmer);
    $em->persist($programmer);
    $em->flush();

    return $this->json($programmer, 200);
  }

  /**
   * Delete a Programmer
   *
   * @Route("/api/programmers/{nickname}", name="delete_programmer")
   * @Method("DELETE")
   * @param Programmer $programmer
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteAction($nickname, Request $request)
  {
    $data = json_decode($request->getContent(), true);
    // die('hello');
    if ($data === null) {
      return $this->json('Not Implemented', 501);
    }

    $em = $this->getDoctrine()->getManager();
    $programmer = $em->getRepository(Programmer::class)->findOneBy(array('nickname' => $nickname));

    if (!$programmer) {
      throw $this->createNotFoundException(sprintf("The programmer %s doesn't exist", $nickname));
    }elseif ($programmer->getNickname() !== $data['nickname']) {
      throw new \Exception("payload data does not match requested resource");
    }

    $em->remove($programmer);
    $em->flush();

    return $this->json(null, 204);
  }

  /**
   * @Route("/api/programmers/{nickname}")
   * @Method("PATCH")
   * @param Request $request
   * @param Programmer $programmer
   * @return JsonResponse
   */
  public function patchAction(Request $request, Programmer $programmer)
  {
    $data = json_decode($request->getContent(), true);

    if ($data === null) {
      return $this->json('Not Implemented', 501);
    }

    if (!$programmer) {
      throw new \Exception("Programmer not found");
    }

    foreach ($data as $key => $value) {
      if ($key !== 'nickname') {
        $func = 'set'. ucfirst($key);
        $programmer->$func($value);
      }
    }

    $this->getDoctrine()->getManager()->flush();

    return $this->json($programmer, 200);
  }
}
