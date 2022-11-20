<?php

namespace App\Controller;

use App\Entity\Contact;
use ReCaptcha\ReCaptcha;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{

    /**
    * @Route("/contact", name="contact_us")
    */
    public function index(Request $request, MailerInterface $mailerInterface)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        
    
        $form->handleRequest($request);

      /* captcha */
        /*
      $recaptcha = new ReCaptcha('6LdDO7wUAAAAAKqDqlV9jGYnaJv2_NRKRgaFVmEa');
      $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
*/
    
            if($form->isSubmitted() && $form->isValid()) {
                /*
                if (!$resp->isSuccess()) {
                    $this->addFlash('success','N\'oubliez pas de cocher la case "Je ne suis pas un robot"');
                  } else {
*/
                $contact = (new Email())
                ->from('infos@avenuedesartistes.com')
                ->to('polvu@hotmail.fr')
                ->subject($contact->getSubject())
                ->replyTo($contact->getEmail())
                ->text($contact->getMessage(),'text/html')
            ;
            
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            $mailerInterface->send($contact);
                
                return $this->redirectToRoute('home');
            }
        
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);   
    }
      
}