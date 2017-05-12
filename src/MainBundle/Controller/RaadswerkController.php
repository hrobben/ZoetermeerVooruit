<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Raadswerk;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Raadswerk controller.
 *
 * @Route("raadswerk")
 */
class RaadswerkController extends Controller
{
    /**
     * Lists all raadswerk entities.
     *
     * @Route("/", name="raadswerk_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $raadswerks = $em->getRepository('MainBundle:Raadswerk')->findAll();

        return $this->render('@Main/raadswerk/index.html.twig', array(
            'raadswerks' => $raadswerks,
        ));
    }

    /**
     * Creates a new raadswerk entity.
     *
     * @Route("/new", name="raadswerk_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $raadswerk = new Raadswerk();
        $form = $this->createForm('MainBundle\Form\RaadswerkType', $raadswerk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($raadswerk);
            $em->flush($raadswerk);

            return $this->redirectToRoute('raadswerk_index');
        }

        return $this->render('@Main/raadswerk/new.html.twig', array(
            'raadswerk' => $raadswerk,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a raadswerk entity.
     *
     * @Route("/{id}", name="raadswerk_show")
     * @Method("GET")
     */
    public function showAction(Raadswerk $raadswerk)
    {
        $deleteForm = $this->createDeleteForm($raadswerk);

        return $this->render('@Main/raadswerk/show.html.twig', array(
            'raadswerk' => $raadswerk,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing raadswerk entity.
     *
     * @Route("/{id}/edit", name="raadswerk_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Raadswerk $raadswerk)
    {
        $deleteForm = $this->createDeleteForm($raadswerk);
        $editForm = $this->createForm('MainBundle\Form\RaadswerkType', $raadswerk);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('raadswerk_index');
        }

        return $this->render('@Main/raadswerk/edit.html.twig', array(
            'raadswerk' => $raadswerk,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a raadswerk entity.
     *
     * @Route("/{id}", name="raadswerk_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Raadswerk $raadswerk)
    {
        $form = $this->createDeleteForm($raadswerk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($raadswerk);
            $em->flush($raadswerk);
        }

        return $this->redirectToRoute('raadswerk_index');
    }

    /**
     * Creates a form to delete a raadswerk entity.
     *
     * @param Raadswerk $raadswerk The raadswerk entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Raadswerk $raadswerk)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('raadswerk_delete', array('id' => $raadswerk->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
