<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\UserReview;
use App\Form\UserReviewType;
use App\Repository\ItemRepository;
use App\Repository\UserReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/userReview")
 */
class UserReviewController extends AbstractController
{
    /**
     * @Route("/", name="user_review_index", methods={"GET"})
     */
    public function index(UserReviewRepository $userReviewRepository): Response
    {
        dd('test');
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        } else {
            return $this->render('user_review/index.html.twig', [
            'user_reviews' => $userReviewRepository->findAll(),
            ]);
        }
    }

    /**
     * @Route("/ajax", name="user_review_ajax", methods={"POST"})
     */
    public function ajaxReview(Request $request, ItemRepository $itemRepository): Response
    {
        $var = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $review = new UserReview();
        $review->setNote($var['rate'])->setReview($var['review'])->setUser($this->getUser())
        ->setItem($itemRepository->findOneBy(['id' => 1]));
        $entityManager->persist($review);
        $entityManager->flush();


        return $this->json([
            'result' => 'result']);
    }

    /**
     * @Route("/new/{item}", name="user_review_new", methods={"GET","POST"})
     */
    public function new(Request $request, Session $session, Item $item): Response
    {
        $userReview = new UserReview();
        $form = $this->createForm(UserReviewType::class, $userReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userReview->setItem($item);
            $userReview->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($userReview);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user_review/new.html.twig', [
            'user_review' => $userReview,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_review_show", methods={"GET"})
     */
    public function show(UserReview $userReview): Response
    {
        return $this->render('user_review/show.html.twig', [
            'user_review' => $userReview,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_review_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserReview $userReview): Response
    {
        $form = $this->createForm(UserReviewType::class, $userReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_review_index');
        }

        return $this->render('user_review/edit.html.twig', [
            'user_review' => $userReview,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_review_delete", methods={"POST"})
     */
    public function delete(Request $request, UserReview $userReview): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userReview->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userReview);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_review_index');
    }
}
