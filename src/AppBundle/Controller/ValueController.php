<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Value;
use AppBundle\Form\ValueType;

/**
 * Value controller.
 *
 */
class ValueController extends Controller
{
    /**
     * Lists all Value entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $values = $em->getRepository('AppBundle:Value')->findAll();

        return $this->render('value/index.html.twig', array(
            'values' => $values,
        ));
    }

    /**
     * Creates a new Value entity.
     *
     */
    public function newAction(Request $request)
    {
        $value = new Value();
        $form = $this->createForm('AppBundle\Form\ValueType', $value);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($value);
            $em->flush();

            return $this->redirectToRoute('value_show', array('id' => $value->getId()));
        }

        return $this->render('value/new.html.twig', array(
            'value' => $value,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Value entity.
     *
     */
    public function showAction(Value $value)
    {
        $deleteForm = $this->createDeleteForm($value);

        return $this->render('value/show.html.twig', array(
            'value' => $value,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Value entity.
     *
     */
    public function editAction(Request $request, Value $value)
    {
        $deleteForm = $this->createDeleteForm($value);
        $editForm = $this->createForm('AppBundle\Form\ValueType', $value);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($value);
            $em->flush();

            return $this->redirectToRoute('value_edit', array('id' => $value->getId()));
        }

        return $this->render('value/edit.html.twig', array(
            'value' => $value,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Value entity.
     *
     */
    public function deleteAction(Request $request, Value $value)
    {
        $form = $this->createDeleteForm($value);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($value);
            $em->flush();
        }

        return $this->redirectToRoute('value_index');
    }

    /**
     * Creates a form to delete a Value entity.
     *
     * @param Value $value The Value entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Value $value)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('value_delete', array('id' => $value->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
