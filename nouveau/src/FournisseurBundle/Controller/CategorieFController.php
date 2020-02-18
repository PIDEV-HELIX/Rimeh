<?php

namespace FournisseurBundle\Controller;

use FournisseurBundle\Entity\CategorieF;

use FournisseurBundle\Form\CategorieFType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CategorieFController extends Controller
{
    public function newAction(Request $request)
    {
        $cat = new CategorieF();
        $form = $this->createForm('FournisseurBundle\Form\CategorieFType', $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            return $this->redirectToRoute('cat_show', array('id' => $cat->getId()));
        }

        return $this->render('@Fournisseur/CategorieF/new.html.twig', array(
            'cat' => $cat,
            'form' => $form->createView(),
        ));

    }


    /**
     * Displays a form to edit an existing cat entity.
     *
     * @Route("/{ids}/edit", name="cat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $cat = $this->getDoctrine()->getRepository(CategorieF::class)->find($id);
        $form = $this->createForm(CategorieFType::class, $cat);

        $form =$form->handleRequest($request);

        if($form->isSubmitted()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();
            return $this->redirectToRoute('cat_index');
        }

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Fournisseur/CategorieF/edit.html.twig', array('form'=>$form->createView()));
        }
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cats = $em->getRepository('FournisseurBundle:CategorieF')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Fournisseur/CategorieF/index.html.twig', array(
                    'cats' => $cats,

                ));

        }


    }


    /*public function user_indexAction(){
        $em = $this->getDoctrine()->getManager();

        $socs = $em->getRepository('ShopBundle:Soc')->findAll();

        return $this->render('@Shop/Soc/user_index.html.twig', array(
            'socs' => $socs,
        ));
    }*/
    /**
     * Finds and displays a categorieF entity.
     *
     * @Route("/{id}", name="cat_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $cat = $em->getRepository('FournisseurBundle:CategorieF')->find($id);
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Fournisseur/CategorieF/show.html.twig', array(
                    'cat' => $cat,
                ));

        }



    }


    public function user_showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $cat = $em->getRepository('FournisseurBundle:CategorieF')->find($id);
        return $this->render('@Fournisseur/CategorieF/user_show.html.twig', array(
            'cat' => $cat,

        ));


    }
    public function inboxAction()
    {
        return $this->render('@Fournisseur/CategorieF/admin_inbox.html.twig');
    }
    /**
     * Displays a form to edit an existing categorieF entity.
     *
     * @Route("/{id}", name="cat_delete")
     * @Method({"GET"})
     */
    public  function deleteAction($id)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(CategorieF::class)->find($id);
        $em->remove($form);
        $em->flush();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->redirectToRoute('cat_index');
        }

    }
}
