<?php

namespace App\Controller;

use App\Repository\TagRepository;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * access to admin main page
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{
    /**
     * to see all categories for admin
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/home/index.html.twig');
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * to see all blog present on website
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $articles): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $articles = $articles->findAll();
            return $this->render('admin/blog/index.html.twig', [
                'articles' => $articles
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }


    /**
     * to see all item to buy on website
     * @Route("/item", name="item")
     */
    public function produit(ItemRepository $items): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $items = $items->findAll();
            return $this->render('admin/produit/index.html.twig', [
                'items' => $items
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }


    /**
     * to see all order of user on website
     * @Route("/shop", name="shop")
     */
    public function shop(OrderRepository $allUserOrder): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $allUserOrder = $allUserOrder->findAll();
            return $this->render('admin/shop/index.html.twig', [
                'allUserOrder' => $allUserOrder
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }


    /**
     * to see all user subscriber on website
     * @Route("/user", name="user")
     */
    public function user(UserRepository $allUserAccount): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $allUserAccount = $allUserAccount->findAll();
            return $this->render('admin/user/index.html.twig', [
                'users' => $allUserAccount
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * to see all tags present on website
     * @Route("/tag", name="tag", methods={"GET"})
     */
    public function tag(TagRepository $tagRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/tag/index.html.twig', [
                'tags' => $tagRepository->findAll(),
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
