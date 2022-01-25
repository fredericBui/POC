<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerService $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data=$form->getData();
            $email=$data['email'];
            $object=$data['object'];
            $message=$data['message'];
            // Mail to admin
            $mailer->sendEmail($email, "admin@gmail.com", $object, "emails/contact.html.twig", ['inputMessage'=>$message]);
            // Mail to user
            $mailer->sendEmail('admin@gmail.com', $email, "Thank you !", "emails/automatic.html.twig", []);
            return $this->render('contact/success.html.twig',[
                'email' => $email
            ]);
        }

        return $this->renderForm('contact/index.html.twig', [
            'formulaire' => $form
        ]);
    }
}
