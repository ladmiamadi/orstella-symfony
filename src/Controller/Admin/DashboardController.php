<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        //if ('supermarket@supermarket.com' === $this->getUser()->getUserIdentifier()) {
            $url = $this->adminUrlGenerator
                ->setController(ProductCrudController::class)
                ->generateUrl();

            return $this->redirect($url);
        //}

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        //return $this->redirect("app_login");
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Products App')
            ->setLocales([
                'en', // locale without custom options
                Locale::new('fr', 'Français', 'far fa-language') // custom label and icon
            ])
            ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section('Stock'),
            MenuItem::linkToCrud('Product', 'fa-solid fa-cart-shopping', Product::class),
            //MenuItem::linkToLogout('Logout', 'fa fa-exit')
        ];
    }
}
