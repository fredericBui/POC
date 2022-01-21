<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Repository\PaymentRepository;
use App\Service\CartService;
use App\Service\PaymentService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment_index")
     */
    public function index(PaymentService $paymentService): Response
    {

        $sessionId = $paymentService->create();
        
        $paymentRequest = new Payment();
        $paymentRequest->setCreateAt(new DateTimeImmutable());
        $paymentRequest->setStripeSessionId($sessionId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paymentRequest);
        $entityManager->flush();

        return $this->render('payment/index.html.twig', [
            'sessionId' => $sessionId
        ]);
    }

    /**
     * @Route("/payment/success/{stripeSessionId}", name="payment_success")
     */
    public function success(string $stripeSessionId, EntityManagerInterface $entityManager, PaymentRepository $paymentRepository, CartService $cartService): Response
    {

        $paymentRequest = $paymentRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId
        ]);
        if(!$paymentRequest){
            return $this->redirectToRoute('cart_index');
        }

        //$paymentRequest->setValidated(true);
        //$paymentRequest->setPaidAt(new DateTime());
;
        $entityManager->flush();

        $cartService->clear();

        return $this->render('payment/success.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    /**
     * @Route("/payment/failure/{stripeSessionId}", name="payment_failure")
     */
    public function failure(string $stripeSessionId, EntityManagerInterface $entityManager, PaymentRepository $paymentRepository): Response
    {

        $paymentRequest = $paymentRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId
        ]);
        if(!$paymentRequest){
            return $this->redirectToRoute('cart_index');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($paymentRequest);
        $entityManager->flush();

        return $this->render('payment/failure.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}
