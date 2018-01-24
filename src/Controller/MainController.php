<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Language;
use App\Form\LangType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Symfony\Component\HttpFoundation\File\File;

/**
 * Main Controller
 */
class MainController extends Controller
{

  /**
   * @Route("/")
   */
   public function homeAction()
   {

    return $this->render('main/welcome.html.twig', array('welcome' => 'So you\'re here, why?'));

   }

   /**
    * @Route("/language/new", name="new_language")
    * @param Request $request
    */
   public function newLanguageAction(Request $request)
   {
     $em = $this->getDoctrine()->getManager();
     $languages = $em->getRepository(Language::class)->findAll();
     $language = new Language();
     $form = $this->createForm(LangType::class, $language);

     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
       $data = $form->getData();
       $em = $this->getDoctrine()->getManager();
       $em->persist($data);
       $em->flush();
       $this->addFlash('notice', 'Language Created Successfully');
       return $this->redirectToRoute('new_language');
     }

     return $this->render('main/language.html.twig', array(
       'languageForm' => $form->createView(),
       'languages' => $languages
     ));


   }
}
