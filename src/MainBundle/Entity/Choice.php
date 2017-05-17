<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Choice
 *
 * @ORM\Table(name="choice")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ChoiceRepository")
 */
class Choice
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
     * @var int
     *
     * @ORM\Column(name="questionId", type="integer")
     */
    private $questionId;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Question")
     * @ORM\JoinColumn(name="questionId", referencedColumnName="id", onDelete="CASCADE")
     */
    private $quId;

    /**
     * @var string
     *
     * @ORM\Column(name="choice", type="string", length=255)
     */
    private $choice;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set questionId
     *
     * @param integer $questionId
     *
     * @return Choice
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return int
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set choice
     *
     * @param string $choice
     *
     * @return Choice
     */
    public function setChoice($choice)
    {
        $this->choice = $choice;

        return $this;
    }

    /**
     * Get choice
     *
     * @return string
     */
    public function getChoice()
    {
        return $this->choice;
    }

    /**
     * Set quId
     *
     * @param \MainBundle\Entity\Question $quId
     *
     * @return Choice
     */
    public function setQuId(\MainBundle\Entity\Question $quId = null)
    {
        $this->quId = $quId;

        return $this;
    }

    /**
     * Get quId
     *
     * @return \MainBundle\Entity\Question
     */
    public function getQuId()
    {
        return $this->quId;
    }
}
