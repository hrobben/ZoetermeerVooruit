<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Enquete;
use MainBundle\Entity\Question;
use MainBundle\Entity\Answer;
use MainBundle\Form\EnqueteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Enquete controller.
 *
 * @Route("enquete")
 */
class EnqueteController extends Controller
{
    /**
     * Lists all enquete entities.
     *
     * @Route("/", name="enquete_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dateTime = new \DateTime("now");

        $enquetes = $em->getRepository('MainBundle:Enquete')->findBy(array(), array('id' => 'DESC'));

        return $this->render('@Main/enquete/index.html.twig', array(
            'enquetes' => $enquetes,
            'dateTime' => $dateTime,
        ));
    }

    /**
     * Creates a new enquete entity.
     *
     * @Route("/new", name="enquete_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $enquete = new Enquete();
        $enquete->setStartDate(new \DateTime("now + 0 day 12:00"));
        $enquete->setEndDate(new \DateTime("now + 2 weeks 1 day 12:00"));

        $form = $this->createForm('MainBundle\Form\EnqueteType', $enquete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enquete);
            $em->flush($enquete);

            return $this->redirectToRoute('question_new', array('enquetenaam' => $enquete->getTitle()));
        }

        return $this->render('@Main/enquete/new.html.twig', array(
            'enquete' => $enquete,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enquete entity.
     *
     * @Route("/{id}", name="enquete_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Enquete $enquete)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $dateTime = new \DateTime("now");

        $questions = $em->getRepository('MainBundle:Question')->findBy(array('enqueteId' => $enquete->getId()));
        $choices = $em->getRepository('MainBundle:Choice')->findAll();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $answers = $em->getRepository('MainBundle:Answer')->findAll();
        }
        else {
            $answers = $em->getRepository('MainBundle:Answer')->findBy(array('user' => $user));
        }

        $allAnswers = $em->getRepository('MainBundle:Answer')->findAll();

        $deleteForm = $this->createDeleteForm($enquete);

//        $payment = $em->getRepository('MainBundle:Payment')->findOneBy(array('userId' => $user, 'endDate' => $dateTime));

        $query = $em->createQuery(
            'SELECT p
            FROM MainBundle:Payment p
            WHERE p.userId = :user 
            AND p.endDate > :date '
        )->setParameter('user', $user)
        ->setParameter('date', $dateTime);
        $payment = $query->getResult();

        if ($payment == null)
        {
            $hasPaid = null;
        }
        else
        {
            $hasPaid = true;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $i = 0;
            foreach ($questions as $question)
            {
                $i++;
                $answer = new Answer();
                $answer->setUser($user);
                $answer->setChoiceId($_POST['radio-'.$i]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($answer);
                $em->flush();
            }

            return $this->redirect($request->getUri());
        }

        return $this->render('@Main/enquete/show.html.twig', array(
            'enquete' => $enquete,
            'dateTime' => $dateTime,
            'questions' => $questions,
            'choices' => $choices,
            'answers' => $answers,
            'show' => true,
            'hasPaid' => $hasPaid,
            'userId' => $user,
            'allAnswers' => $allAnswers,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enquete entity.
     *
     * @Route("/{id}/edit", name="enquete_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Enquete $enquete)
    {
        $deleteForm = $this->createDeleteForm($enquete);
        $editForm = $this->createForm('MainBundle\Form\EnqueteType', $enquete);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enquete_edit', array('id' => $enquete->getId()));
        }

        return $this->render('@Main/enquete/edit.html.twig', array(
            'enquete' => $enquete,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enquete entity.
     *
     * @Route("/{id}", name="enquete_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Enquete $enquete)
    {
        $form = $this->createDeleteForm($enquete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enquete);
            $em->flush($enquete);
        }

        return $this->redirectToRoute('enquete_index');
    }

    /**
     * Creates a form to delete a enquete entity.
     *
     * @param Enquete $enquete The enquete entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Enquete $enquete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('enquete_delete', array('id' => $enquete->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
