<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Info;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Info controller.
 *
 * @Route("info")
 */
class InfoController extends Controller
{
    /**
     * Lists all info entities.
     *
     * @Route("/", name="info_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $infos = $em->getRepository('MainBundle:Info')->findAll();

        return $this->render('@Main/info/index.html.twig', array(
            'infos' => $infos,
        ));
    }

    /**
     * Creates a new info entity.
     *
     * @Route("/new", name="info_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $info = new Info();
        $form = $this->createForm('MainBundle\Form\InfoType', $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($info);
            $em->flush($info);

            return $this->redirectToRoute('info_show', array('id' => $info->getId()));
        }

        return $this->render('@Main/info/new.html.twig', array(
            'info' => $info,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a info entity.
     *
     * @Route("/{id}", name="info_show")
     * @Method("GET")
     */
    public function showAction(Info $info)
    {
        $deleteForm = $this->createDeleteForm($info);

        return $this->render('@Main/info/show.html.twig', array(
            'info' => $info,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing info entity.
     *
     * @Route("/{id}/edit", name="info_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Info $info)
    {
        $deleteForm = $this->createDeleteForm($info);
        $editForm = $this->createForm('MainBundle\Form\InfoType', $info);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('info_edit', array('id' => $info->getId()));
        }

        return $this->render('@Main/info/edit.html.twig', array(
            'info' => $info,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a info entity.
     *
     * @Route("/{id}", name="info_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Info $info)
    {
        $form = $this->createDeleteForm($info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($info);
            $em->flush($info);
        }

        return $this->redirectToRoute('info_index');
    }

    /**
     * Creates a form to delete a info entity.
     *
     * @param Info $info The info entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Info $info)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('info_delete', array('id' => $info->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
