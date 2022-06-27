<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Backend');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Event','fa fa-calendar',EventCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Group','fa fa-users',GroupCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Member','fa fa-user',MemberCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Region','fa fa-map-signs',RegionCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Socials','fa fa-external-link',SocialMediaCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Style','fa fa-shield',StyleCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Time periode','fa fa-hourglass',TimeperiodeCrudController::getEntityFqcn());
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(20)
            ;
    }
}
