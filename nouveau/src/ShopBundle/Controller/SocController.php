<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Soc;

use ShopBundle\Form\SocType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SocController extends Controller
{
    public function newAction(Request $request)
    {
        $soc = new Soc();
        $form = $this->createForm('ShopBundle\Form\SocType', $soc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $logo */
            $logo = $form->get('logo')->getData();


            if ($logo) {
                $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logo->guessClientExtension();


                try {
                    $logo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $soc->setLogo($newFilename);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($soc);
            $em->flush();

            return $this->redirectToRoute('soc_show', array('ids' => $soc->getIds()));
        }

        return $this->render('@Shop/Soc/new.html.twig', array(
            'soc' => $soc,
            'form' => $form->createView(),
        ));

    }


    /**
     * Displays a form to edit an existing soc entity.
     *
     * @Route("/{ids}/edit", name="soc_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $ids)
    {
        $soc = $this->getDoctrine()->getRepository(Soc::class)->find($ids);
        $soc->setLogo(new File($this->getParameter('images_directory').'/'.$soc->getLogo()));
        $form = $this->createForm(SocType::class, $soc);

        $form =$form->handleRequest($request);

        if($form->isSubmitted()){
            /** @var UploadedFile $logo */
            $logo = $form->get('logo')->getData();


            if ($logo) {
                $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logo->guessClientExtension();


                try {
                    $logo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $soc->setLogo($newFilename);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($soc);
            $em->flush();
            return $this->redirectToRoute('soc_index');
        }

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Shop/Soc/edit.html.twig', array('form'=>$form->createView()));

        }

    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $socs = $em->getRepository('ShopBundle:Soc')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Shop/Soc/index.html.twig', array(
                    'socs' => $socs,

                ));

        }


    }


    public function user_indexAction(){
        $em = $this->getDoctrine()->getManager();

        $socs = $em->getRepository('ShopBundle:Soc')->findAll();

        return $this->render('@Shop/Soc/user_index.html.twig', array(
            'socs' => $socs,
        ));
    }
    /**
     * Finds and displays a soc entity.
     *
     * @Route("/{ids}", name="soc_show")
     * @Method("GET")
     */
    public function showAction($ids)
    {
        $em = $this->getDoctrine()->getManager();

        $soc = $em->getRepository('ShopBundle:Soc')->find($ids);
        $vehs =  $em->getRepository('ShopBundle:Veh')->findBy(array('ids'=>$ids));

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Shop/Soc/show.html.twig', array(
                    'soc' => $soc,
                    'vehs'=>$vehs,
                ));

        }



    }


    public function user_showAction($ids)
    {
        $em = $this->getDoctrine()->getManager();

        $soc = $em->getRepository('ShopBundle:Soc')->find($ids);
        $vehs =  $em->getRepository('ShopBundle:Veh')->findBy(array('ids'=>$ids));
        return $this->render('@Shop/Soc/user_show.html.twig', array(
            'soc' => $soc,
            'vehs'=>$vehs,
        ));


    }
    public function inboxAction()
    {
        return $this->render('@Shop/Soc/admin_inbox.html.twig');
    }
    /**
     * Displays a form to edit an existing soc entity.
     *
     * @Route("/{ids}", name="soc_delete")
     * @Method({"GET"})
     */
    public  function deleteAction($ids)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(Soc::class)->find($ids);
        $em->remove($form);
        $em->flush();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->redirectToRoute('soc_index');
        }



    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('p');
        $socs =  $em->getRepository('ShopBundle:Soc')->findEntitiesByString($requestString);
        if(!$socs) {
            $result['$socs']['error'] = "Soc Not found :( ";
        } else {
            $result['$socs'] = $this->getRealEntities($socs);
        }
        return new Response(json_encode($result));

    }

    public function getRealEntities($socs){
        foreach ($socs as $socs){
            $realEntities[$socs->getIds()] = [$socs->getLogo(),$socs->getNames()];
        }
        return $realEntities;
    }

}
