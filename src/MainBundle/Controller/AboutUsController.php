<?php

namespace MainBundle\Controller;

use MainBundle\Entity\AboutUs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Aboutus controller.
 *
 * @Route("overons")
 */
class AboutUsController extends Controller
{
    /**
     * Lists all aboutUs entities.
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
     * Creates a new aboutUs entity.
     *
     * @Route("/new", name="aboutus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $aboutUs = new AboutUs();
        $form = $this->createForm('MainBundle\Form\AboutUsType', $aboutUs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded PDF file
            $file = $aboutUs->getPicture();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $aboutUs->setPicture($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($aboutUs);
            $em->flush();

            return $this->redirectToRoute('aboutus_index', array('id' => $aboutUs->getId()));
        }

        return $this->render('@Main/aboutus/new.html.twig', array(
            'aboutUs' => $aboutUs,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a aboutUs entity.
     *
     * @Route("/{id}", name="aboutus_show")
     * @Method("GET")
     */
    public function showAction(AboutUs $aboutUs)
    {
        $deleteForm = $this->createDeleteForm($aboutUs);

        return $this->render('@Main/aboutus/show.html.twig', array(
            'aboutUs' => $aboutUs,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing aboutUs entity.
     *
     * @Route("/{id}/edit", name="aboutus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AboutUs $aboutUs)
    {
        $deleteForm = $this->createDeleteForm($aboutUs);
        $editForm = $this->createForm('MainBundle\Form\AboutUsType', $aboutUs);
        $editForm->handleRequest($request);

        // Oude afbeelding ophalen




        if ($editForm->isSubmitted()) {

            if (strlen($aboutUs->getPicture()) > 25){

                $aboutUs->setPicture(
                    new File($this->getParameter('brochures_directory') . '/' . $aboutUs->getPicture())
                );
            }

            // $file stores the uploaded PDF file
            $file = $aboutUs->getPicture();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $aboutUs->setPicture($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aboutus_edit', array('id' => $aboutUs->getId()));
        }

        return $this->render('@Main/aboutus/edit.html.twig', array(
            'aboutUs' => $aboutUs,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aboutUs entity.
     *
     * @Route("/{id}", name="aboutus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AboutUs $aboutUs)
    {
        $form = $this->createDeleteForm($aboutUs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutUs);
            $em->flush($aboutUs);
        }

        return $this->redirectToRoute('aboutus_index');
    }

    /**
     * Creates a form to delete a aboutU entity.
     *
     * @param AboutUs $aboutUs The aboutUs entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AboutUs $aboutUs)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aboutus_delete', array('id' => $aboutUs->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
