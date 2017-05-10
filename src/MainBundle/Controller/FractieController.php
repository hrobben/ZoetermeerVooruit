<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Fractie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fractie controller.
 *
 * @Route("fractie")
 */
class FractieController extends Controller
{
    /**
     * Lists all fractie entities.
     *
     * @Route("/", name="fractie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fracties = $em->getRepository('MainBundle:Fractie')->findAll();

        return $this->render('@Main/fractie/index.html.twig', array(
            'fracties' => $fracties,
        ));
    }

    /**
     * Creates a new fractie entity.
     *
     * @Route("/new", name="fractie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fractie = new Fractie();
        $form = $this->createForm('MainBundle\Form\FractieType', $fractie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fractie);
            $em->flush($fractie);

            return $this->redirectToRoute('fractie_show', array('id' => $fractie->getId()));
        }

        return $this->render('@Main/fractie/new.html.twig', array(
            'fractie' => $fractie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fractie entity.
     *
     * @Route("/{id}", name="fractie_show")
     * @Method("GET")
     */
    public function showAction(Fractie $fractie)
    {
        $deleteForm = $this->createDeleteForm($fractie);

        return $this->render('@Main/fractie/show.html.twig', array(
            'fractie' => $fractie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fractie entity.
     *
     * @Route("/{id}/edit", name="fractie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fractie $fractie)
    {
        $deleteForm = $this->createDeleteForm($fractie);
        $editForm = $this->createForm('MainBundle\Form\FractieType', $fractie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fractie_edit', array('id' => $fractie->getId()));
        }

        return $this->render('@Main/fractie/edit.html.twig', array(
            'fractie' => $fractie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fractie entity.
     *
     * @Route("/{id}", name="fractie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fractie $fractie)
    {
        $form = $this->createDeleteForm($fractie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fractie);
            $em->flush($fractie);
        }

        return $this->redirectToRoute('fractie_index');
    }

    /**
     * Creates a form to delete a fractie entity.
     *
     * @param Fractie $fractie The fractie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fractie $fractie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fractie_delete', array('id' => $fractie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
