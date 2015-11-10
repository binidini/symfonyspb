<?php

namespace Spb\SymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Spb\SymfonyBundle\Entity\Message;
use Spb\SymfonyBundle\Entity\Subscription;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Spb\SymfonyBundle\Form\Type\MessageType;
use Spb\SymfonyBundle\Form\Type\SubscriptionType;

class DefaultController extends Controller
{

    public function serviceAction($service)
    {
        return $this->render('SpbSymfonyBundle:Default:details.html.twig', array('service' => $service));
    }
    
    
    public function messageAction(Request $request)
    {
        $msg = new Message();
        
        $form = $this->createForm(new MessageType(), $msg);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {

            $message = \Swift_Message::newInstance()
                ->setSubject('symfony.spb.ru message')
                ->setTo('denis@symfony.spb.ru')
                ->setFrom($form->get('email')->getData())
                ->setBody(
                    $this->renderView(
                        'SpbSymfonyBundle:Default:email.txt.twig',
                        array('name' => $form->get('name')->getData(),
                            'email' => $form->get('email')->getData(),
                            'subject' => $form->get('subject')->getData(),
                            'msg' => $form->get('msg')->getData()
                        )
                    )
                )
            ;
            
            $this->get('mailer')->send($message);
            
            $this->get('session')->getFlashBag()->add('notice', 'Ваше письмо успешно отправлено');
        }        

        return $this->render('SpbSymfonyBundle:Default:contacts.html.twig', 
                array('form' => $form->createView(),));
    }
    
    public function subscriptionAction()
    {
        $subscription = new Subscription();
        
        $form =  $this->createForm(new SubscriptionType(), $subscription);
        
        return $this->render('SpbSymfonyBundle:Default:subscription-form.html.twig', array(
            'form' => $form->createView(),
            ));
    }
    
    public function subscribeAction(Request $request)
    {
        $sbs = new Subscription();        
        $form = $this->createForm(new SubscriptionType(), $sbs);        
        $form->handleRequest($request);
        
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($sbs);
            $em->flush();

            $response = array("code" => 1, "success" => true, "msg" => "E-mail добавлен в рассылку новостей.");
        } else {
            $response = array("code" => -1, "success" => false, "msg" => $form->getErrorsAsString());
        }
        
        return new Response(json_encode($response)); 
    }     
}
