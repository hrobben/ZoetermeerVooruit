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
        $infos = $em->getRepository('MainBundle:Info')->findBy(array(), array('id' => 'DESC'), 3);

        return $this->render('MainBundle:Default:index.html.twig', array(
            'infos' => $infos,
        ));
    }
}
