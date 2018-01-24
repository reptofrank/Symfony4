<?php

namespace App\Controller;

use App\Entity\Programmer;
use App\Form\ProgrammerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/programmers")
 */
class ProgrammerController extends Controller
{

  /**
   * @Route("/new", name="register_programmer")
   * @param Request $request
   * @return return type
   */
  public function newAction(Request $request)
  {
    $programmer = new Programmer();

    // $form = $this->createFormBuilder($programmer)
    //             ->add('nickname', TextType::class)
    //             ->add('avatarNumber', NumberType::class)
    //             ->add('tagLine', TextareaType::class, array('label' => 'Tag Line'))
    //             ->add('created', DateType::class, array('widget' => 'single_text', 'label' => 'Due Date'))
    //             ->getForm();

    $form = $this->createForm(ProgrammerType::class, $programmer);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $data = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();

      return $this->redirectToRoute('show_programmer', array('nickname' => $data->getNickname()));
    }
    return $this->render('main/new.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/{nickname}", name="show_programmer")
   * @param Programmer $programmer
   */
  public function showAction(Programmer $programmer)
  {
    if (!$programmer) {
      throw new NotFoundHttpException('Programmer not found');
    }

    return $this->render('main/show.html.twig', array(
      'programmer' => $programmer
    ));
  }
}
