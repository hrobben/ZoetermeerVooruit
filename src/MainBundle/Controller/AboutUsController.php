<?php

namespace MainBundle\Controller;

use MainBundle\Entity\AboutUs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Aboutu controller.
 *
 * @Route("aboutus")
 */
class AboutUsController extends Controller
{
    /**
     * Lists all aboutU entities.
     *
     * @Route("/", name="aboutus_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aboutuses = $em->getRepository('MainBundle:AboutUs')->findAll();

        return $this->render('@Main/aboutus/index.html.twig', array(
            'aboutuses' => $aboutuses,
        ));
    }

    /**
     * Creates a new aboutU entity.
     *
     * @Route("/new", name="aboutus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $aboutU = new Aboutu();
        $form = $this->createForm('MainBundle\Form\AboutUsType', $aboutU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aboutU);
            $em->flush($aboutU);

            return $this->redirectToRoute('aboutus_show', array('id' => $aboutU->getId()));
        }

        return $this->render('@Main/aboutus/new.html.twig', array(
            'aboutU' => $aboutU,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a aboutU entity.
     *
     * @Route("/{id}", name="aboutus_show")
     * @Method("GET")
     */
    public function showAction(AboutUs $aboutU)
    {
        $deleteForm = $this->createDeleteForm($aboutU);

        return $this->render('@Main/aboutus/show.html.twig', array(
            'aboutU' => $aboutU,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing aboutU entity.
     *
     * @Route("/{id}/edit", name="aboutus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AboutUs $aboutU)
    {
        $deleteForm = $this->createDeleteForm($aboutU);
        $editForm = $this->createForm('MainBundle\Form\AboutUsType', $aboutU);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aboutus_edit', array('id' => $aboutU->getId()));
        }

        return $this->render('@Main/aboutus/edit.html.twig', array(
            'aboutU' => $aboutU,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aboutU entity.
     *
     * @Route("/{id}", name="aboutus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AboutUs $aboutU)
    {
        $form = $this->createDeleteForm($aboutU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutU);
            $em->flush($aboutU);
        }

        return $this->redirectToRoute('aboutus_index');
    }

    /**
     * Creates a form to delete a aboutU entity.
     *
     * @param AboutUs $aboutU The aboutU entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AboutUs $aboutU)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aboutus_delete', array('id' => $aboutU->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
