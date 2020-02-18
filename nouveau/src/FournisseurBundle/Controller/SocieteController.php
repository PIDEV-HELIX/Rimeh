<?php

namespace FournisseurBundle\Controller;

use FournisseurBundle\Entity\Societe;
use FournisseurBundle\Form\SocieteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SocieteController extends Controller
{
    public function newAction(Request $request)
    {
        //test de places
        $societe = new Societe();
        $form = $this->createForm('FournisseurBundle\Form\SocieteType', $societe);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $logo */
            $logo = $form->get('logo')->getData();


            if ($logo) {
                $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logo->guessClientExtension();


                try {
                    $logo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $societe->setLogo($newFilename);


            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($societe);
            $em->flush();

            return $this->redirectToRoute('societe_show', array('ids' => $societe->getIds()));
        }

        return $this->render('@Fournisseur/Societe/new.html.twig', array(
            'societe' => $societe,

            'form' => $form->createView(),
        ));

    }

    public function indexAction()
    {
        //test de date if date today is between debut date and fin date --> show + state (programmed/displaying/history)
        $em = $this->getDoctrine()->getManager();


        $societes = $em->getRepository('FournisseurBundle:Societe')->findAll();

        return $this->render('@Fournisseur/Societe/index.html.twig', array(
            'societes' => $societes,
        ));

    }

    /**
     * Finds and displays a societe entity.
     *
     * @Route("/{ids}", name="societe_show")
     * @Method("GET")
     */
    public function showAction($ids)
    {

        $em = $this->getDoctrine()->getManager();

        $societe = $em->getRepository('FournisseurBundle:Societe')->find($ids);
        return $this->render('@Fournisseur/Societe/show.html.twig', array(
            'societe' => $societe,

        ));

    }
    /**
     * Displays a form to edit an existing societe entity.
     *
     * @Route("/{ids}", name="societe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $ids)
    {
        $societe = $this->getDoctrine()->getRepository(Societe::class)->find($ids);
        $societe->setLogo(new File('uploads/images/11-5e440b974a910.jpeg'));


        $form = $this->createForm(SocieteType::class, $societe);
        $form =$form->handleRequest($request);
        if($form->isSubmitted()){


            $logo = $form->get('logo')->getData();


            if ($logo) {
                $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logo->guessClientExtension();


                try {
                    $logo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $societe->setLogo($newFilename);


            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($societe);
            $em->flush();
            return $this->redirectToRoute('societe_index');
        }
        return $this->render('@Fournisseur/Societe/edit.html.twig', array('form'=>$form->createView()));

    }

    /**
     * Displays a form to edit an existing societe entity.
     *
     * @Route("/{ids}", name="societe_delete")
     * @Method({"GET"})
     */
    public  function deleteAction($ids)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(Societe::class)->find($ids);
        $em->remove($form);
        $em->flush();
        return $this->redirectToRoute('societe_index');

    }

}
