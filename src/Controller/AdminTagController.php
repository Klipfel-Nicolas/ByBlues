<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag", name="admin_tag_")
 */
class AdminTagController extends AbstractController
{
    /**
     * @Route("/new", name="newTag", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $tag = new Tag();
            $form = $this->createForm(TagType::class, $tag);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($tag);
                $entityManager->flush();

                return $this->redirectToRoute('admin_tag');
            }

            return $this->render('admin/tag/new.html.twig', [
                'tag' => $tag,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/{id}", name="showTag", methods={"GET"})
     */
    public function show(Tag $tag): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/tag/show.html.twig', [
                'tag' => $tag,
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/{id}/edit", name="editTag", methods={"GET","POST"})
     */
    public function edit(Request $request, Tag $tag): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(TagType::class, $tag);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('admin_tag');
            }

            return $this->render('admin/tag/edit.html.twig', [
                'tag' => $tag,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/{id}", name="deleteTag", methods={"POST"})
     */
    public function delete(Request $request, Tag $tag): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            if ($this->isCsrfTokenValid('delete' . $tag->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($tag);
                $entityManager->flush();
            }

            return $this->redirectToRoute('admin_tag');
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
