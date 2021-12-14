<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderController extends AbstractController
{
    /**
     * @Route("/payement_order/{id}", name="order_payment")
     */
    public function paymentOrder(): Response
    {
        return $this->render('order/payment.html.twig');
    }

    /**
     * @Route("/payement_order_accept", name="order_payment_accept")
     */
    public function paymentOrderAccept(SessionInterface $session): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $this->getUser()]);
        $commande = new Order();
        $commande
            ->setTotalPrice($session->get('totalPrice'))
            ->setUser($user);
        $entityManager = $this->getDoctrine()->getManager();

        foreach ($session->get('order') as $itemId => $quantity) {
            $item = $this->getDoctrine()->getRepository(Item::class)->findOneBy(['id' => $itemId]);
            $item = $commande->addItem($item);
            $entityManager->persist($item);
            $entityManager->flush();
        }
        $entityManager->persist($commande);
        $entityManager->flush();
        $session->clear();
        return $this->redirectToRoute('shop_index');
    }

    /**
     * @Route("/ordersPlaced/{id}", name="orderPlacedUser")
     */
    public function orderPlaced(): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $orders = $this->getDoctrine()->getRepository(Order::class)->findBy(['user' => $this->getUser()]);
            return $this->render('user/orderPlaced.html.twig', [
                'orders' => $orders
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/ordersPlacedShow/{id}", name="ordersPlacedShow")
     */
    public function orderPlacedShow(int $id, Order $order): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $uniqueOrder = $this->getDoctrine()->getRepository(Order::class)->findOneBy(['id' => $id]);
            return $this->render('user/orderPlacedShow.html.twig', [
                'order' => $order,
                'uniqueorder' => $uniqueOrder,
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
