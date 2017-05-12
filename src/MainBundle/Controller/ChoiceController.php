<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Choice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Choice controller.
 *
 * @Route("choice")
 */
class ChoiceController extends Controller
{
    /**
     * Lists all choice entities.
     *
     * @Route("/", name="choice_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $choices = $em->getRepository('MainBundle:Choice')->findAll();

        return $this->render('@Main/choice/index.html.twig', array(
            'choices' => $choices,
        ));
    }

    /**
     * Creates a new choice entity.
     *
     * @Route("/new", name="choice_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $choice = new Choice();
        $form = $this->createForm('MainBundle\Form\ChoiceType', $choice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($choice);
            $em->flush($choice);

            return $this->redirectToRoute('choice_new', array('id' => $choice->getId()));
        }

        return $this->render('@Main/choice/new.html.twig', array(
            'choice' => $choice,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a choice entity.
     *
     * @Route("/{id}", name="choice_show")
     * @Method("GET")
     */
    public function showAction(Choice $choice)
    {
        $deleteForm = $this->createDeleteForm($choice);

        return $this->render('@Main/choice/show.html.twig', array(
            'choice' => $choice,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing choice entity.
     *
     * @Route("/{id}/edit", name="choice_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Choice $choice)
    {
        $deleteForm = $this->createDeleteForm($choice);
        $editForm = $this->createForm('MainBundle\Form\ChoiceType', $choice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('choice_edit', array('id' => $choice->getId()));
        }

        return $this->render('@Main/choice/edit.html.twig', array(
            'choice' => $choice,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a choice entity.
     *
     * @Route("/{id}", name="choice_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Choice $choice)
    {
        $form = $this->createDeleteForm($choice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($choice);
            $em->flush($choice);
        }

        return $this->redirectToRoute('choice_index');
    }

    /**
     * Creates a form to delete a choice entity.
     *
     * @param Choice $choice The choice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Choice $choice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('choice_delete', array('id' => $choice->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
