<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="programmer")
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammerRepository")
 */
class Programmer
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
     * @Assert\NotBlank(message="Please enter a clever nickname")
     * @var string
     */
    private $nickname;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="please enter a number, dont be unfortunate")
     * @var int
     */
     private $avatarNumber;

     /**
      * @ORM\ManyToOne(targetEntity="Language")
      * @var Language
      */
     private $language;

     /**
      * @ORM\Column(type="string", nullable=true)
      * @var string
      */
     private $tagLine;

     /**
      * @ORM\Column(type="datetime", nullable=true)
      * @var \DateTime
      */
     private $created;

     /**
      * @ORM\ManyToMany(targetEntity="Project", inversedBy="programmer")
      * @ORM\JoinColumn(name="programmer_project")
      * @var ArrayCollection
      */
     private $project;

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
    public function getNickname()
    {
      return $this->nickname;
    }

    /**
     * @param string $nickname
     *
     * @return static
     */
    public function setNickname($nickname)
    {
      $this->nickname = $nickname;
      return $this;
    }

    /**
     * @return int
     */
    public function getAvatarNumber()
    {
      return $this->avatarNumber;
    }

    /**
     * @param int $avatarNumber
     *
     * @return static
     */
    public function setAvatarNumber($avatarNumber)
    {
      $this->avatarNumber = $avatarNumber;
      return $this;
    }

    /**
     * @return string
     */
    public function getTagLine()
    {
      return $this->tagLine;
    }

    /**
     * @param string $tagLine
     *
     * @return static
     */
    public function setTagLine($tagLine)
    {
      $this->tagLine = $tagLine;
      return $this;
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

    /**
     * @return ArrayCollection
     */
    public function getProject()
    {
      return $this->project;
    }

    /**
     * @param Project $project
     *
     * @return static
     */
    public function setProject($project)
    {
      $this->project[] = $project;
    }

    /**
     * @return Language
     */
    public function getLanguage()
    {
      return $this->language;
    }

    /**
     * @param Language $language
     *
     * @return static
     */
    public function setLanguage(Language $language)
    {
      $this->language = $language;
      return $this;
    }

}
