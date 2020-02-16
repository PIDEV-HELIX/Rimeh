<?php

namespace fournisseurBundle\Controller;

use fournisseurBundle\Entity\commandeF;
use fournisseurBundle\Form\SocieteType;
use fournisseurBundle\Entity\Societe;
use fournisseurBundle\Form\commandeFType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commandef controller.
 *
 */
class commandeFController extends Controller
{
    /**
     * Lists all commandeF entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandeFs = $em->getRepository('fournisseurBundle:commandeF')->findAll();

        return $this->render('commandef/index.html.twig', array(
            'commandeFs' => $commandeFs,
        ));
    }

    /**
     * Creates a new commandeF entity.
     *
     */
    public function newAction(Request $request)
    {
        $commandeF = new Commandef();
        $form = $this->createForm('fournisseurBundle\Form\commandeFType', $commandeF);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandeF);
            $em->flush();

            return $this->redirectToRoute('commandef_index', array('id' => $commandeF->getId()));
        }

        return $this->render('commandef/new.html.twig', array(
            'commandeF' => $commandeF,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commandeF entity.
     *
     */
    public function showAction(commandeF $commandeF)
    {
        $deleteForm = $this->createDeleteForm($commandeF);

        return $this->render('commandef/show.html.twig', array(
            'commandeF' => $commandeF,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commandeF entity.
     *
     */
    public function editAction(Request $request, commandeF $commandeF)
    {
        $deleteForm = $this->createDeleteForm($commandeF);
        $editForm = $this->createForm('fournisseurBundle\Form\commandeFType', $commandeF);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commandef_edit', array('id' => $commandeF->getId()));
        }

        return $this->render('commandef/edit.html.twig', array(
            'commandeF' => $commandeF,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commandeF entity.
     *
     */
    public function deleteAction(Request $request, commandeF $commandeF)
    {
        $form = $this->createDeleteForm($commandeF);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commandeF);
            $em->flush();
        }

        return $this->redirectToRoute('commandef_index');
    }

    /**
     * Creates a form to delete a commandeF entity.
     *
     * @param commandeF $commandeF The commandeF entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(commandeF $commandeF)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commandef_delete', array('id' => $commandeF->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
