<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToMany(targetEntity="Programmer", mappedBy="project")
     * @ORM\JoinTable(name="programmer_project")
     * @var ArrayCollection
     */
    private $programmer;


    function __construct()
    {
      $this->programmer = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
      $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getProgrammer()
    {
      return $this->programmer;
    }

    /**
     * @param Programmer $programmer
     *
     * @return static
     */
    public function setProgrammer($programmer)
    {
      $this->programmer[] = $programmer;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
      return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return static
     */
    public function setCreated(\DateTime $created)
    {
      $this->created = $created;
      return $this;
    }
}
