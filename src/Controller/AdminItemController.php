<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Item;
use App\Form\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/admin/item", name="admin_item_")
 */
class AdminItemController extends AbstractController
{
    /**
     * @Route("/new", name="newItem", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $item = new Item();
            $form = $this->createForm(ItemType::class, $item);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $item   ->setDisplayPerDay(3)
                        ->setIsPreOrder(0);
                $entityManager->persist($item);
                $entityManager->flush();

                $iterations = 4;
                for ($i = 1; $i <= $iterations; $i++) {
                    $image = new Image();
                    $imageFile = $form['image' . $i]->getData();
                    $filePath = uniqid() . $imageFile->getClientOriginalName();

                    $imageFile->move(
                        $this->getParameter('item_directory'),
                        $filePath
                    );

                    $image->setPath($filePath);
                    $image->setItem($item);
                    $image->setImagePlace($i);
                    $entityManager->persist($image);
                    $entityManager->flush();
                }

                return $this->redirectToRoute('admin_item');
            }

            return $this->render('admin/produit/new.html.twig', [
                'item' => $item,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Item $item): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $images = $this->getDoctrine()->getRepository(Image::class)->findBy(['item' => $item->getId()]);

            return $this->render('admin/produit/show.html.twig', [
                'item' => $item,
                'images' => $images,
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Item $item): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $images = $this->getDoctrine()->getRepository(Image::class)->findBy(['item' => $item->getId()]);
            $filesystem = new Filesystem();

            $form = $this->createForm(ItemType::class, $item);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $iterations = 4;
                for ($i = 1; $i <= $iterations; $i++) {
                    if ($form['image' . $i]->getData()) {
                        $removePath = $this->getParameter('item_directory') . '/' . $images[$i - 1]->getPath();
                        $filesystem->remove($removePath);
                        $imageFile = $form['image' . $i]->getData();
                        $filePath = uniqid() . $imageFile->getClientOriginalName();

                        $imageFile->move(
                            $this->getParameter('item_directory'),
                            $filePath
                        );

                        $images[$i - 1]->setPath($filePath);
                        $images[$i - 1]->setItem($item);
                        $images[$i - 1]->setImagePlace($i);
                        $entityManager->persist($images[$i - 1]);
                        $entityManager->flush();
                    }
                }

                return $this->redirectToRoute('admin_item');
            }
            return $this->render('admin/produit/edit.html.twig', [
                'item' => $item,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Item $item): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            if ($this->isCsrfTokenValid('delete' . $item->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($item);
                $entityManager->flush();
            }
            return $this->redirectToRoute('admin_item');
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
