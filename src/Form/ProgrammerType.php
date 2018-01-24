<?php

namespace App\Form;

use App\Entity\Programmer;
use App\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Programmer Form Class
 */
class ProgrammerType extends AbstractType
{

  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
        ->add('nickname', TextType::class, array('label' => 'Enter Nickname'))
        ->add('created', DateType::class, array('widget' => 'single_text'))
        ->add('tagLine', TextareaType::class, array('label' => 'Tag Line'))
        ->add('avatarNumber', ChoiceType::class, array(
          'label' => 'Avatar Number',
          'choices' => [
              'Novice' => 1,
              'Beginner' => 2,
              'Intermediate' => 3,
              'Professional' => 4,
              'Expert' => 5,
              'Ninja' => 6
            ],
          'placeholder' => 'Select One'
        ))
        ->add('language', null, array('label' => 'Language'))
        ->add('agreeTerms', CheckboxType::class, array('mapped' => false));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
        'data_class' => Programmer::class,
    ));
  }

}
