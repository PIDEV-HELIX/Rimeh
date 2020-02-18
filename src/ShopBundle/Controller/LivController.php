<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Liv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Liv controller.
 *
 * @Route("livF")
 */
class LivController extends Controller
{
    /**
     * Lists all liv entities.
     *
     * @Route("/", name="liv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $livs = $em->getRepository('ShopBundle:Liv')->findAll();

        return $this->render('liv/index.html.twig', array(
            'livs' => $livs,
        ));
    }

    /**
     * Creates a new liv entity.
     *
     * @Route("/new", name="liv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $liv = new Liv();
        $form = $this->createForm('ShopBundle\Form\LivType', $liv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($liv);
            $em->flush();

            return $this->redirectToRoute('liv_show', array('id' => $liv->getId()));
        }

        return $this->render('liv/new.html.twig', array(
            'liv' => $liv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a liv entity.
     *
     * @Route("/{id}", name="liv_show")
     * @Method("GET")
     */
    public function showAction(Liv $liv)
    {
        $deleteForm = $this->createDeleteForm($liv);

        return $this->render('liv/show.html.twig', array(
            'liv' => $liv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing liv entity.
     *
     * @Route("/{id}/edit", name="liv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Liv $liv)
    {
        $deleteForm = $this->createDeleteForm($liv);
        $editForm = $this->createForm('ShopBundle\Form\LivType', $liv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liv_edit', array('id' => $liv->getId()));
        }

        return $this->render('liv/edit.html.twig', array(
            'liv' => $liv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a liv entity.
     *
     * @Route("/{id}", name="liv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Liv $liv)
    {
        $form = $this->createDeleteForm($liv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($liv);
            $em->flush();
        }

        return $this->redirectToRoute('liv_index');
    }

    /**
     * Creates a form to delete a liv entity.
     *
     * @param Liv $liv The liv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Liv $liv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('liv_delete', array('id' => $liv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
