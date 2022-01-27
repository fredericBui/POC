<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Purchase;
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
    public function success(string $stripeSessionId, EntityManagerInterface $entityManager, CartService $cartService, PaymentRepository $paymentRepository): Response
    {

        $paymentRequest = $paymentRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId
        ]);
        if(!$paymentRequest){
            return $this->redirectToRoute('cart_index');
        }

        //$paymentRequest->setValidated(true);
        //$paymentRequest->setPaidAt(new DateTime());

        $order = new Purchase();
        $order->setCreateAt(new DateTimeImmutable());
        //$order->setPoc();
        $order->setBuyer($this->getUser());
        $order->setReference(strval(rand(1000000,999999999)));
        $entityManager->persist($order);

        /*$cart = $cartService->get();
        foreach ($cart['elements'] as $pocId => $element)
        {
            $poc = $pocRepository->find($pocId);
            $orderedQuantity = new OrderedQuantity();
            $orderedQuantity->setQuantity($element['quantity']);
            $orderedQuantity->setPoc($poc);
            $orderedQuantity->setFromOrder($order);
            $entityManager->persist($orderedQuantity);

        };*/

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

        $entityManager->remove($paymentRequest);
        $entityManager->flush();

        return $this->render('payment/failure.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}
