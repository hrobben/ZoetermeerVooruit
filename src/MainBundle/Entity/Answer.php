<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="an")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="choiceId", type="integer")
     */
    private $choiceId;


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
     * Set choiceId
     *
     * @param integer $choiceId
     *
     * @return Answer
     */
    public function setChoiceId($choiceId)
    {
        $this->choiceId = $choiceId;

        return $this;
    }

    /**
     * Get choiceId
     *
     * @return int
     */
    public function getChoiceId()
    {
        return $this->choiceId;
    }

    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Answer
     */
    public function setUser(\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
