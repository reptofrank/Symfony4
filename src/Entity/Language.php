<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $icon;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=0, max=100, minMessage="Come on man, enter a number greater than {{ limit }}", maxMessage="Really?? that popular?? I dont think so")
     * @var int
     */
    private $popularity;

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
      return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return static
     */
    public function setIcon(string $icon)
    {
      $this->icon = $icon;
      return $this;
    }

    /**
     * @return int
     */
    public function getPopularity()
    {
      return $this->popularity;
    }

    /**
     * @param int $popularity
     *
     * @return static
     */
    public function setPopularity(int $popularity)
    {
      $this->popularity = $popularity;
      return $this;
    }

    public function __toString()
    {
      return $this->name;
    }
}
