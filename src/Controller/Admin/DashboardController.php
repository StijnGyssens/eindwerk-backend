<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Backend');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Event','fa fa-home',EventCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Group','fa fa-home',GroupCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Member','fa fa-home',MemberCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Region','fa fa-home',RegionCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Socials','fa fa-home',SocialMediaCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Style','fa fa-home',StyleCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Time periode','fa fa-home',TimeperiodeCrudController::getEntityFqcn());
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
