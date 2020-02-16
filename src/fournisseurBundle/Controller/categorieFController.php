<?php

namespace fournisseurBundle\Controller;

use fournisseurBundle\Entity\categorieF;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categorief controller.
 *
 */
class categorieFController extends Controller
{
    /**
     * Lists all categorieF entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieFs = $em->getRepository('fournisseurBundle:categorieF')->findAll();

        return $this->render('categorief/index.html.twig', array(
            'categorieFs' => $categorieFs,
        ));
    }

    /**
     * Creates a new categorieF entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorieF = new Categorief();
        $form = $this->createForm('fournisseurBundle\Form\categorieFType', $categorieF);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieF);
            $em->flush();

            return $this->redirectToRoute('categorief_show', array('id' => $categorieF->getId()));
        }

        return $this->render('categorief/new.html.twig', array(
            'categorieF' => $categorieF,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieF entity.
     *
     */
    public function showAction(categorieF $categorieF)
    {
        $deleteForm = $this->createDeleteForm($categorieF);

        return $this->render('categorief/show.html.twig', array(
            'categorieF' => $categorieF,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieF entity.
     *
     */
    public function editAction(Request $request, categorieF $categorieF)
    {
        $deleteForm = $this->createDeleteForm($categorieF);
        $editForm = $this->createForm('fournisseurBundle\Form\categorieFType', $categorieF);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorief_edit', array('id' => $categorieF->getId()));
        }

        return $this->render('categorief/edit.html.twig', array(
            'categorieF' => $categorieF,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieF entity.
     *
     */
    public function deleteAction(Request $request, categorieF $categorieF)
    {
        $form = $this->createDeleteForm($categorieF);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieF);
            $em->flush();
        }

        return $this->redirectToRoute('categorief_index');
    }

    /**
     * Creates a form to delete a categorieF entity.
     *
     * @param categorieF $categorieF The categorieF entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(categorieF $categorieF)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorief_delete', array('id' => $categorieF->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
