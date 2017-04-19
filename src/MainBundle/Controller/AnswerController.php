<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Answer controller.
 *
 * @Route("answer")
 */
class AnswerController extends Controller
{
    /**
     * Lists all answer entities.
     *
     * @Route("/", name="answer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $answers = $em->getRepository('MainBundle:Answer')->findAll();

        return $this->render('@FOSUser/answer/index.html.twig', array(
            'answers' => $answers,
        ));
    }

    /**
     * Finds and displays a answer entity.
     *
     * @Route("/{id}", name="answer_show")
     * @Method("GET")
     */
    public function showAction(Answer $answer)
    {

        return $this->render('@FOSUser/answer/show.html.twig', array(
            'answer' => $answer,
        ));
    }
}
