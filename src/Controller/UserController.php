<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Services\Slugify;
use App\Form\UserProfilType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("account/{slug}", name="account")
     */
    public function viewAccount(User $user): Response
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findBy(['user' => $this->getUser()->getId()]);

        if ($this->isGranted('ROLE_USER')) {
            return $this->render('user/account.html.twig', [
                'user' => $user,
                'orders' => $orders
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/review")
     */
    public function review(): Response
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/shopping/{id}", name="shopping")
     */
    public function index(SessionInterface $session, ItemRepository $itemRepository, User $user)
    {
        if ($this->isGranted('ROLE_USER')) {
            $order = $session->get('order', []);
            $orderWithData = [];
            foreach ($order as $id => $quantity) {
                $orderWithData[] = [
                    'item' => $itemRepository->find($id),
                    'quantity' => $quantity,
                ];
            }
            $total = 0;

            foreach ($orderWithData as $element) {
                $totalElement = $element['item']->getPrice() * $element['quantity'];
                $total += $totalElement;
            }
            $session->set('totalPrice', $total);
            return $this->render('user/shopping.html.twig', [
                'elements' => $orderWithData
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/edit/{slug}", name="edit_user")
     */
    public function editUser(Request $request, User $user, Slugify $slugify): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $form = $this->createForm(UserProfilType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Profil changé avec succès !');
                return $this->redirectToRoute('user_account', ['slug' => $this->getUser()->getSlug()]);
            }
            return $this->render('user/edit.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/panier/add/{id}", name ="item_add")
     */
    public function add($id, SessionInterface $session, Request $request)
    {
        if (!$this->getUser()) {
            $this->addFlash(
                'success',
                'Vous devez être inscrit'
            );
            return $this->redirect($request->headers->get('referer'));
        }
        $order = $session->get('order', []);

        if (!empty($order[$id])) {
            $order[$id]++;
        } else {
            $order[$id] = 1;
        }

        $session->set('order', $order);
        $this->addFlash(
            'success',
            'Article ajouté au panier'
        );
        $request->getSession();
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/panier/remove{id}", name ="item_remove")
     */
    public function remove($id, SessionInterface $session, Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            $order = $session->get('order', []);

            if (!empty($order[$id])) {
                unset($order[$id]);
            }
            $session->set('order', $order);
            $this->addFlash(
                'alert',
                'article supprimé'
            );
            $request->getSession();
            return $this->redirect($request->headers->get('referer'));
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
