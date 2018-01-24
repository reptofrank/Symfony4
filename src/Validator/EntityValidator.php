<?php

namespace App\Validator;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Validate input againse constraints defined in Entity
 */
class EntityValidator
{

  /**
   * @var ValidatorInterface
   */
  var $validator;

  /**
   * @param ValidatorInterface $validator
   */
  function __construct(ValidatorInterface $validator)
  {
    $this->validator = $validator;
  }

  /**
   * @param Entity $obj
   * @return array $errorsData
   */
  public function validate($obj)
  {
    $errors = $this->validator->validate($obj);
    $errorsData = array();

    foreach ($errors as $error) {
      $errorsData[$error->getPropertyPath()] = $error->getMessage();
    }

    return $errorsData;
  }
}
