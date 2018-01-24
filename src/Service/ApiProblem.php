<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * Set Api Errors
 */
class ApiProblem
{
  /**
   * @var string
   */
  private $type;

  /**
   * @var string
   */
  private $title;

  /**
   * @var int
   */
  private $statusCode;

  /**
   * @var array
   */
  private $extra = array();

  /**
   * @var string
   */
  const TYPE_VALIDATION_ERROR = 'validation_error';

  /**
   * @var string
   */
  const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';

  /**
   * @var string
   */
  const TYPE_INVALID_REQUEST_URI = 'about:blank';

  /**
   * @var array
   */
   static private $titles = array(
         self::TYPE_VALIDATION_ERROR => 'There was a validation error',
         self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent',
         self::TYPE_INVALID_REQUEST_URI => 'Not Found'
     );


  function __construct($statusCode, $type = null)
  {
    if (!$type) {
      $this->type = 'about:blank';
      $this->title = (null !== Response::$statusTexts[$statusCode]) ? Response::$statusTexts[$statusCode] : 'Unknown status code :(';
    }else {
      $this->type = $type;
      if (!isset(self::$titles[$type])) {
        throw new \InvalidArgumentException(sprintf("There are no titles that match %s", $type));
      }
      $this->title = self::$titles[$type];
    }
      
      $this->statusCode = $statusCode;
  }

  /**
   * @return int
   */
  public function getStatusCode(): int
  {
    return $this->statusCode;
  }

  /**
   * @return string
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @return void
   * @param string $name
   * @param mixed $value
   */
  public function extraData($name, $value)
  {
    $this->extra[$name] = $value;
  }

  /**
   * @return array
   */
  public function toArray()
  {
    $apiErrors = array_merge(
        $this->extra,
        array(
          'type' => $this->type,
          'title' => $this->title,
          'statusCode' => $this->statusCode
        )
      );

    return $apiErrors;
  }
}
