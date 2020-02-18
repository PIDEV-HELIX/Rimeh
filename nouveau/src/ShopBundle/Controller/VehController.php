<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Veh;
use ShopBundle\Form\VehType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class VehController extends Controller
{
    public function newAction(Request $request)
    {
        //test de places
        $veh = new Veh();
        $form = $this->createForm('ShopBundle\Form\VehType', $veh);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $veh = $em->getRepository('ShopBundle:Livr')->editHistoryAdQB();
            /** @var UploadedFile $ad */
            $ad = $form->get('ad')->getData();


            if ($ad) {
                $originalFilename = pathinfo($ad->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $ad->guessClientExtension();


                try {
                    $ad->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $veh->setAd($newFilename);


            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($veh);
            $em->flush();

            return $this->redirectToRoute('veh_show', array('idad' => $veh->getIdad()));
        }

        return $this->render('@Shop/Veh/new.html.twig', array(
            'veh' => $veh,

            'form' => $form->createView(),
        ));

    }

    public function indexAction()
    {
        //test de date if date today is between debut date and fin date --> show + state (programmed/displaying/history)
        $em = $this->getDoctrine()->getManager();

        $vehs = $em->getRepository('ShopBundle:Veh')->editCurrentAdQB();

        $vehs = $em->getRepository('ShopBundle:Veh')->editProgAdQB();

        $vehs = $em->getRepository('ShopBundle:Veh')->findAll();

        return $this->render('@Shop/Veh/index.html.twig', array(
            'vehs' => $vehs,
        ));

    }

    /**
     * Finds and displays a veh entity.
     *
     * @Route("/{idad}", name="veh_show")
     * @Method("GET")
     */
    public function showAction($idad)
    {

        $em = $this->getDoctrine()->getManager();

        $veh = $em->getRepository('ShopBundle:Veh')->find($idad);
        return $this->render('@Shop/Veh/show.html.twig', array(
            'veh' => $veh,

        ));

    }
    /**
     * Displays a form to edit an existing veh entity.
     *
     * @Route("/{idad}", name="veh_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $idad)
    {
        $veh = $this->getDoctrine()->getRepository(Veh::class)->find($idad);
        $veh->setAd(new File('uploads/images/11-5e440b974a910.jpeg'));


        $form = $this->createForm(VehType::class, $veh);
        $form =$form->handleRequest($request);
        if($form->isSubmitted()){


            $ad = $form->get('ad')->getData();


            if ($ad) {
                $originalFilename = pathinfo($ad->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $ad->guessClientExtension();


                try {
                    $ad->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $veh->setAd($newFilename);


            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($veh);
            $em->flush();
            return $this->redirectToRoute('veh_index');
        }
        return $this->render('@Shop/Veh/edit.html.twig', array('form'=>$form->createView()));

    }

    /**
     * Displays a form to edit an existing veh entity.
     *
     * @Route("/{idad}", name="veh_delete")
     * @Method({"GET"})
     */
    public  function deleteAction($idad)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(Veh::class)->find($idad);
        $em->remove($form);
        $em->flush();
        return $this->redirectToRoute('veh_index');

    }

}
