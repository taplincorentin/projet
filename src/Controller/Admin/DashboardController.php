<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Theme;
use App\Entity\Topic;
use App\Entity\Balade;
use App\Entity\Report;
use App\Entity\Seance;
use App\Entity\Personne;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        
        return $this->redirect($adminUrlGenerator->setController(PersonneCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Back to HomePage', 'fa-solid fa-backward', 'app_home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', Personne::class);
        yield MenuItem::linkToCrud('Walks', 'fa-solid fa-dog', Balade::class);
        yield MenuItem::linkToCrud('Training sessions', 'fa-solid fa-graduation-cap', Seance::class);
        yield MenuItem::linkToCrud('Sessions themes', 'fa-solid fa-lines-leaning', Theme::class);
        yield MenuItem::linkToCrud('Categories', 'fa-solid fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Topics', 'fa-solid fa-puzzle-piece', Topic::class);
        yield MenuItem::linkToCrud('Posts', 'fa-solid fa-pen', Post::class);
        yield MenuItem::linkToCrud('Reports', 'fa-solid fa-flag', Report::class);
        
        
    }
}
