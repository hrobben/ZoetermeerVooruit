<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="enqueteId", type="integer")
     */
    private $enqueteId;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Enquete")
     * @ORM\JoinColumn(name="enqueteId", referencedColumnName="id", onDelete="CASCADE")
     */
    private $eqId;


    protected $choices;

    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    public function newChoice(Choice $choice)
    {
        $choice->addQuestion($this);

        $this->choices->add($choice);
    }

    public function removeChoice(Choice $choice)
    {
        $this->choices->removeElement($choice);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Question
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set enqueteId
     *
     * @param integer $enqueteId
     *
     * @return Question
     */
    public function setEnqueteId($enqueteId)
    {
        $this->enqueteId = $enqueteId;
    
        return $this;
    }

    /**
     * Get enqueteId
     *
     * @return integer
     */
    public function getEnqueteId()
    {
        return $this->enqueteId;
    }

    /**
     * @return ArrayCollection
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param ArrayCollection $choices
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

    /**
     * Set eqId
     *
     * @param \MainBundle\Entity\Enquete $eqId
     *
     * @return Question
     */
    public function setEqId(\MainBundle\Entity\Enquete $eqId = null)
    {
        $this->eqId = $eqId;
    
        return $this;
    }

    /**
     * Get eqId
     *
     * @return \MainBundle\Entity\Enquete
     */
    public function getEqId()
    {
        return $this->eqId;
    }

    public function __toString()
    {
        return $this->title;
    }



    /**
     * Add choice
     *
     * @param \MainBundle\Entity\Choice $choice
     *
     * @return Question
     */
    public function addChoice(\MainBundle\Entity\Choice $choice)
    {
        $choice->setQuId($this);
        $this->choices[] = $choice;

        return $this;
    }
}
