<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\BaladeRepository;
use App\Repository\SeanceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function search(Request $request, BaladeRepository $baladeRepository, SeanceRepository $seanceRepository): Response
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ville = $form->get('ville')->getData();
            $type = $form->get('type')->getData();

            // Perform actions based on the selected search type (concerts/plays)
            if ($type === 'balades') {

                //get walks with same ville
                $resultatsBalades = $baladeRepository->findBy(['ville' => $ville]);

                return $this->render('balade/resultats.html.twig', [
                    'resultatsBalades' => $resultatsBalades,
                    'ville' => $ville
                ]);

            } elseif ($type === 'seances') {
                //get seances with same ville
                $resultatsSeances = $seanceRepository->findBy(['ville' => $ville]);

                return $this->render('seance/resultats.html.twig', [
                    'resultatsSeances' => $resultatsSeances,
                    'ville' => $ville
                ]);
            }
        }

        return $this->render('search/index.html.twig', [
            'searchForm' => $form->createView(),
        ]);
    }
}
