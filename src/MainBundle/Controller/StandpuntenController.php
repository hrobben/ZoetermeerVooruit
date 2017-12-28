<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Standpunten;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Standpunten controller.
 *
 * @Route("standpunten")
 */
class StandpuntenController extends Controller
{
    /**
     * Lists all standpunten entities.
     *
     * @Route("/", name="standpunten_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $standpuntens = $em->getRepository('MainBundle:Standpunten')->findAll();

        return $this->render('@Main/standpunten/index.html.twig', array(
            'standpuntens' => $standpuntens,
        ));
    }

    /**
     * Creates a new standpunten entity.
     *
     * @Route("/new", name="standpunten_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $standpunten = new Standpunten();
        $form = $this->createForm('MainBundle\Form\StandpuntenType', $standpunten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($standpunten);
            $em->flush($standpunten);

            return $this->redirectToRoute('standpunten_index');
        }

        return $this->render('@Main/standpunten/new.html.twig', array(
            'standpunten' => $standpunten,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a standpunten entity.
     *
     * @Route("/{id}", name="standpunten_show")
     * @Method("GET")
     */
    public function showAction(Standpunten $standpunten)
    {
        $deleteForm = $this->createDeleteForm($standpunten);

        return $this->render('@Main/standpunten/show.html.twig', array(
            'standpunten' => $standpunten,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing standpunten entity.
     *
     * @Route("/{id}/edit", name="standpunten_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Standpunten $standpunten)
    {
        $deleteForm = $this->createDeleteForm($standpunten);
        $editForm = $this->createForm('MainBundle\Form\StandpuntenType', $standpunten);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('standpunten_index');
        }

        return $this->render('@Main/standpunten/edit.html.twig', array(
            'standpunten' => $standpunten,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a standpunten entity.
     *
     * @Route("/{id}", name="standpunten_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Standpunten $standpunten)
    {
        $form = $this->createDeleteForm($standpunten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($standpunten);
            $em->flush($standpunten);
        }

        return $this->redirectToRoute('standpunten_index');
    }

    /**
     * Creates a form to delete a standpunten entity.
     *
     * @param Standpunten $standpunten The standpunten entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Standpunten $standpunten)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('standpunten_delete', array('id' => $standpunten->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
