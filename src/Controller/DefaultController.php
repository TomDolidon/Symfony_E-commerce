<?php

namespace App\Controller;

use App\Repository\LigneCommandeRepository;
use App\Service\PanierService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class DefaultController extends AbstractController {
    public function index() {
        return $this->render('index.html.twig');
    }

    public function navBar(Panierservice $panierService) {

        $nbArticles = $panierService->getNbProduits();

        return$this->render('navBar.html.twig', [ "nbArticles" => $nbArticles]);

    }

    public function sidebar(LigneCommandeRepository $ligneCommandeRepository) {

        $topProductNumberToDisplay = 3;
        $topSells = $ligneCommandeRepository->getTopSells();
        $NTopSells = array_slice($topSells, 0, $topProductNumberToDisplay);

        return$this->render('sidebar.html.twig', [ "topSells" => $NTopSells]);
    }

}

?>
