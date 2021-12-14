<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use Doctrine\ORM\EntityManager;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * to check all Order on website
 * @Route("/admin/order", name="admin_order_")
 */

class AdminOrderController extends AbstractController
{
    /**
     * @Route("/show/{order}/order/{user}", name="show_order_user")
     */
    public function showUserOrder(Order $order,User $user): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $items = $order->getItems();

            return $this->render('admin/order/show.html.twig', [
                'order' => $order,
                'user' => $user,
                'items' => $items
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/delete/{id}/order", name="delete_order_user", methods={"POST","GET"})
     */
    public function deleteOrderUser(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_shop');
    }
}
