<?php

namespace fournisseurBundle\Controller;

use fournisseurBundle\Entity\categorieF;
use fournisseurBundle\Entity\Societe;
use fournisseurBundle\Form\categorieFType;
use fournisseurBundle\Form\SocieteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Societe controller.
 *
 */
class SocieteController extends Controller
{
    /**
     * Lists all societe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $societes = $em->getRepository('fournisseurBundle:Societe')->findAll();

        return $this->render('societe/index.html.twig', array(
            'societes' => $societes,
        ));
    }

    /**
     * Creates a new societe entity.
     *
     */
    public function newAction(Request $request)
    {
        $societe = new Societe();
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($societe);
            $em->flush();

            return $this->redirectToRoute('societe_index', array('id' => $societe->getId()));
        }

        return $this->render('societe/new.html.twig', array(
            'societe' => $societe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a societe entity.
     *
     */
    public function showAction(Societe $societe)
    {
        $deleteForm = $this->createDeleteForm($societe);

        return $this->render('societe/show.html.twig', array(
            'societe' => $societe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing societe entity.
     *
     */
    public function editAction(Request $request, Societe $societe)
    {
        $deleteForm = $this->createDeleteForm($societe);
        $editForm = $this->createForm('fournisseurBundle\Form\SocieteType', $societe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('societe_edit', array('id' => $societe->getId()));
        }

        return $this->render('societe/edit.html.twig', array(
            'societe' => $societe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a societe entity.
     *
     */
    public function deleteAction(Request $request, Societe $societe)
    {
        $form = $this->createDeleteForm($societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($societe);
            $em->flush();
        }

        return $this->redirectToRoute('societe_index');
    }

    /**
     * Creates a form to delete a societe entity.
     *
     * @param Societe $societe The societe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Societe $societe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('societe_delete', array('id' => $societe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
