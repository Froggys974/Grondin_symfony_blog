<?php

namespace App\Handler;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\FormInterface;

class ArticleHandler
{
    private $entityManager;
    private $formFactory;
    // private $session;
    private $articleRepository;

    public function __construct(
        EntityManagerInterface $entityManager, 
        FormFactoryInterface $formFactory, 
        // SessionInterface $session,
        ArticleRepository $articleRepository
    ) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        // $this->session = $session;
        $this->articleRepository = $articleRepository;
    }

    public function handleNew(Request $request): FormInterface
    {
        $article = new Article();
        $form = $this->formFactory->create(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($article);
            $this->entityManager->flush();

            // $this->session->getFlashBag()->add('success', 'Article created successfully.');
        }

        return $form;
    }

    public function handleEdit(Request $request, Article $article): FormInterface
    {
        $form = $this->formFactory->create(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            // $this->session->getFlashBag()->add('success', 'Article updated successfully.');
        }

        return $form;
    }

    public function handleDelete(Request $request, Article $article): void
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($article);
            $this->entityManager->flush();

            // $this->session->getFlashBag()->add('success', 'Article deleted successfully.');
        }
    }

    public function handleShow(Article $article): Article
    {
        return $article;
    }
}
