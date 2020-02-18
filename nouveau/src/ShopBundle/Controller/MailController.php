<?php

namespace ShopBundle\Controller;

use Doctrine\DBAL\Types\TextType;
use ShopBundle\Entity\Mail;
use ShopBundle\Entity\Soc;
use ShopBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class MailController extends Controller
{
   public function inboxAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mails = $em->getRepository('ShopBundle:Mail')->findAll();
        return $this->render('@Shop/Mail/admin_inbox.html.twig', array('mails' => $mails));

    }


    public function sendAction(Request $request, $ids)
    {
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();
        $soc = $em->getRepository('ShopBundle:Soc')->find($ids);
        $mail->setMailto($soc->getEmail());

        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = $mail->getSubject();
            $mailto = $mail->getMailto();
            $object = $mail->getObject();
            $username = 'ach.thamri@gmail.com';
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($mailto)
                ->setBody($object, 'text/html');
            $this->get('mailer')->send($message);


            $mail->setMailfrom($username);
            $mail->setTime(new \DateTime());
            $mail->setIds($soc);

            $em->persist($mail);
            $em->flush();

            $mails = $em->getRepository('ShopBundle:Mail')->findAll();
            return $this->render('@Shop/Mail/admin_inbox.html.twig', array('mails' => $mails));

        }


        return $this->render('@Shop/Mail/send.html.twig', array('form' => $form->createView()));
    }


    public function composeAction(Request $request)
    {
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = $mail->getSubject();
            $mailto = $mail->getMailto();
            $object = $mail->getObject();
            $username = 'ach.thamri@gmail.com';
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($mailto)
                ->setBody($object, 'text/html');

            //  $message->attach(Swift_Attachment::fromPath('full-path-with-attachment-name'));
            $this->get('mailer')->send($message);


            $mail->setMailfrom($username);
            $mail->setTime(new \DateTime());


            $em->persist($mail);
            $em->flush();

            $mails = $em->getRepository('ShopBundle:Mail')->findAll();
            return $this->render('@Shop/Mail/admin_inbox.html.twig', array('mails' => $mails));
        }

    }

    /*public function searchBarAction()
    {
        $form=$this->createFormBuilder(null)
        ->add('recherche', TextType::class)
            ->getForm();
        return $this->render('@Shop/Mail/admin_inbox.html.twig', [
            'form'=> $form->createView()]);
    }*/

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('p');
        $mail =  $em->getRepository('ShopBundle:Mail')->findEntitiesByString($requestString);
        if(!$mail) {
            $result['$mail']['error'] = "Post Not found :( ";
        } else {
            $result['$mail'] = $this->getRealEntities($mail);
        }
        return new Response(json_encode($result));

    }

    public function getRealEntities($mail){
        foreach ($mail as $mails){
            $realEntities[$mails->getId()] = [$mails->getSubject(),$mails->getObject()];

        }
        return $realEntities;
    }

    public function searchhAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $mails=$em->getRepository(Mail::class)->findAll();
        if($request->isMethod("POST"))
        {
            $subject=$request->get('subject');
            $mails=$em->getRepository('ShopBundle:Mail')->findBy(array('subject'=>$subject));
        }
        return $this->render('@Shop/Mail/admin_inbox.html.twig',array('mails'=>$mails));

    }
}
