<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MainBundle\Entity\Info;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $enquete = $em->createQuery('SELECT e FROM MainBundle:Enquete e WHERE e.endDate < CURRENT_DATE() ORDER BY e.id DESC')->setMaxResults(1)->getOneOrNullResult();
        if ($enquete != null)
        {
            $questions = $em->getRepository('MainBundle:Question')->findBy(array('enqueteId' => $enquete->getId()));
            $choices = $em->getRepository('MainBundle:Choice')->findAll();
            $allAnswers = $em->getRepository('MainBundle:Answer')->findAll();
        }
        else
        {
            $questions = null;
            $choices = null;
            $allAnswers = null;
        }
        $infos = $em->getRepository('MainBundle:Info')->findBy(array(), array('id' => 'DESC'), 2);

        return $this->render('MainBundle:Default:index.html.twig', array(
            'infos' => $infos,
            'enquete' => $enquete,
            'choices' => $choices,
            'questions' => $questions,
            'allAnswers' => $allAnswers,
        ));
    }
}
