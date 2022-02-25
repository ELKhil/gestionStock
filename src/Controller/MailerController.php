<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
        #[Route('/send_email',name: 'send_email')]
        public function sendEmail(MailerInterface $mailer): Response
        {
            $email =(new Email())
                ->from('noreply.bformation@gmail.com')
                ->to('m.s.elkhil@gmail.com')

                ->subject("Accusé de réception")
                ->text("Nous avons bien reçu votre message !!!!!!!");


            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
            }
            return $this->render('default/home.html.twig.');
        }
}