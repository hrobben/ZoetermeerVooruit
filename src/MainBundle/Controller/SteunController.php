<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Steun;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Steun controller.
 *
 * @Route("steun")
 */
class SteunController extends Controller
{
    /**
     * Lists all steun entities.
     *
     * @Route("/", name="steun_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $steuns = $em->getRepository('MainBundle:Steun')->findAll();

        return $this->render('@Main/steun/index.html.twig', array(
            'steuns' => $steuns,
        ));
    }

    /**
     * Creates a new steun entity.
     *
     * @Route("/new", name="steun_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $steun = new Steun();
        $form = $this->createForm('MainBundle\Form\SteunType', $steun);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($steun);
            $em->flush($steun);

            return $this->redirectToRoute('steun_index');
        }

        return $this->render('@Main/steun/new.html.twig', array(
            'steun' => $steun,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a steun entity.
     *
     * @Route("/{id}", name="steun_show")
     * @Method("GET")
     */
    public function showAction(Steun $steun)
    {
        $deleteForm = $this->createDeleteForm($steun);

        return $this->render('@Main/steun/show.html.twig', array(
            'steun' => $steun,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing steun entity.
     *
     * @Route("/{id}/edit", name="steun_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Steun $steun)
    {
        $deleteForm = $this->createDeleteForm($steun);
        $editForm = $this->createForm('MainBundle\Form\SteunType', $steun);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('steun_index');
        }

        return $this->render('@Main/steun/edit.html.twig', array(
            'steun' => $steun,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a steun entity.
     *
     * @Route("/{id}", name="steun_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Steun $steun)
    {
        $form = $this->createDeleteForm($steun);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($steun);
            $em->flush($steun);
        }

        return $this->redirectToRoute('steun_index');
    }

    /**
     * Creates a form to delete a steun entity.
     *
     * @param Steun $steun The steun entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Steun $steun)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('steun_delete', array('id' => $steun->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
