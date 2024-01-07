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
        $form = $this->createForm(SearchFormType::class);   //form creation
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ville = $form->get('ville')->getData();        //get search city from form
            $type = $form->get('type')->getData();          //get type of event from form

            //if user searching for a walk
            if ($type === 'balades') {

                //get walks with same ville
                $resultatsBalades = $baladeRepository->getBaladesFuturesParVille($ville);

                //return walk objects + city name to view
                return $this->render('balade/resultats.html.twig', [
                    'resultatsBalades' => $resultatsBalades,
                    'ville' => $ville
                ]);
            
            //if user searching for a training session
            } elseif ($type === 'seances') {
                //get seances with same ville
                $resultatsSeances = $seanceRepository->getSeancesFuturesParVille($ville);

                return $this->render('seance/resultats.html.twig', [
                    'resultatsSeances' => $resultatsSeances,
                    'ville' => $ville
                ]);
            }
        }
        
        //form rendering
        return $this->render('search/index.html.twig', [
            'searchForm' => $form->createView(),
        ]);
    }
}
