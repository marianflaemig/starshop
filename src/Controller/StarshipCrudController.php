<?php

namespace App\Controller;

use App\Entity\Starship;
use App\Form\StarshipType;
use App\Repository\StarshipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/starship/crud')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class StarshipCrudController extends AbstractController
{
    #[Route(name: 'app_starship_crud_index', methods: ['GET'])]
    public function index(StarshipRepository                              $starshipRepository,
                          PaginatorInterface                              $paginator,
                          Request                                         $request
    ): Response
    {
        $queryBuilder = $starshipRepository->getBaseQueryBuilder();

        $paginator = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('starship_crud/index.html.twig', [
            'pagination' => $paginator
        ]);
    }

    #[Route('/new', name: 'app_starship_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $starship = new Starship();
        $form = $this->createForm(StarshipType::class, $starship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($starship);
            $entityManager->flush();

            return $this->redirectToRoute('app_starship_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('starship_crud/new.html.twig', [
            'starship' => $starship,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_starship_crud_show', methods: ['GET'])]
    public function show(Starship $starship): Response
    {
        return $this->render('starship_crud/show.html.twig', [
            'starship' => $starship,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_starship_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Starship $starship, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StarshipType::class, $starship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_starship_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('starship_crud/edit.html.twig', [
            'starship' => $starship,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_starship_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Starship $starship, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $starship->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($starship);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_starship_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
