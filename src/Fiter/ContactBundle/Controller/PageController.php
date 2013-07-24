<?php

namespace Fiter\ContactBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Fiter\ContactBundle\Entity\Enquiry;
use Fiter\ContactBundle\Form\EnquiryType;

/**
 * Page controller.
 *
 * @Route("/contacto")
 */
class PageController extends Controller{

    /**
     * Muestra la pagina de contacto
     *
     * @Route("/", name="_fiter_contact", requirements={"_method" = "GET|POST"}  ) 
     * @Template()
     */
    public function contactAction(){
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
    
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
    
            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from 9fiter')
                    ->setFrom('enquiries@muchomoi.no-ip.org')
                    ->setTo($this->container->getParameter('fiter_contact.emails.contact_email'))
                    ->setBody($this->renderView('FiterContactBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);
                $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
                return $this->redirect($this->generateUrl('fiter_contact'));
            }
        }
        return $this->render('FiterContactBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}



