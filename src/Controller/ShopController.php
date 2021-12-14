<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/shop", name="shop_")
 */
class ShopController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(ItemRepository $items, ImageRepository $images): Response
    {
        $items = $items->findAll();
        $images = $images->findAll();
        return $this->render('shop/index.html.twig', [
            'items' => $items,
            'images' => $images
        ]);
    }

    /**
     * @Route("/show/{id}", name="show_item")
     */
    public function showItem(Item $item): Response
    {
        return $this->render('shop/show.html.twig', [
            'item' => $item
        ]);
    }
}
