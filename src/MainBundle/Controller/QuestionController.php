<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Choice;
use MainBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Question controller.
 *
 * @Route("question")
 */
class QuestionController extends Controller
{
    /**
     * Lists all question entities.
     *
     * @Route("/", name="question_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('MainBundle:Question')->findAll();
        $enquetes = $em->getRepository('MainBundle:Enquete')->findAll();

        return $this->render('@FOSUser/question/index.html.twig', array(
            'questions' => $questions,
            'enquetes' => $enquetes,
        ));
    }

    /**
     * Creates a new question entity.
     *
     * @Route("/new", name="question_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $question = new Question();

       /* $choice1 = new Choice();
        $question->getChoices()->add($choice1);*/

        $form = $this->createForm('MainBundle\Form\QuestionType', $question);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

           /* $em->persist($question);
            $em->flush();

            $choice1->setQuId($question);
            $em->persist($choice1);
            $em->flush();*/
            $em->persist($question);

            $this->getDoctrine()->getManager()->flush();

           // dump($question->getChoices());die;
            foreach ($question->getChoices() as $choice){
                $question->addChoice($choice);

                $em->persist($choice);
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('question_new');
        }

        return $this->render('@Main/question/new.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a question entity.
     *
     * @Route("/{id}", name="question_show")
     * @Method("GET")
     */
    public function showAction(Question $question)
    {
        $em = $this->getDoctrine()->getManager();
        $choices = $em->getRepository('MainBundle:Choice')->findBy(['questionId'=>$question->getId()]);

        $deleteForm = $this->createDeleteForm($question);
        return $this->render('@Main/question/show.html.twig', array(
            'question' => $question,
            'choices' => $choices,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing question entity.
     *
     * @Route("/{id}/edit", name="question_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);

        $em = $this->getDoctrine()->getManager();
        $choices = $em->getRepository('MainBundle:Choice')->findBy(['questionId'=>$question->getId()]);

       $question->setChoices($choices);

        $editForm = $this->createForm('MainBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            foreach ($question->getChoices() as $choice){
                $question->addChoice($choice);
                $em->persist($choice);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_edit', array('id' => $question->getId()));
        }

        return $this->render('@Main/question/edit.html.twig', array(
            'question' => $question,
            'choices' => $choices,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a question entity.
     *
     * @Route("/{id}", name="question_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Question $question)
    {
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush($question);
        }

        return $this->redirectToRoute('question_index');
    }

    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('question_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
