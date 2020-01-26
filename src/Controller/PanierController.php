<?php

namespace App\Controller;

use App\Service\BoutiqueService;
use App\Service\DeviseService;
use App\Service\MailService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(PanierService $panierService, DeviseService $deviseService)
    {

        $p = $panierService->getContenu();

        $total = $panierService->getTotal();

        return $this->render('panier/index.html.twig', [
            "panier" => $p, "total" => $total, "devise" => $deviseService->getStringDevise()
        ]);
    }

    public function ajouter($idProduit, $quantite, PanierService $panierService )
    {
        $panierService->ajouterProduit($idProduit, $quantite);
       return$this->redirectToRoute('panier_index');
    }

    public function enlever($idProduit, $quantite, PanierService $panierService )
    {
        $panierService->enleverProduit($idProduit, $quantite);
        return$this->redirectToRoute('panier_index');
    }

    public function supprimer($idProduit, PanierService $panierService )
    {
        $panierService->supprimerProduit($idProduit);
        return$this->redirectToRoute('panier_index');
    }

    public function validation(PanierService $panierService, MailService $mailService )
    {
        $user = $this->getUser();

        if ($user == null) {
            return $this->redirectToRoute('app_login');
        } else {
            $commande = $panierService -> panierToCommande($user);
            $mailService->sendEmailForCommandSuccess($commande);
            return $this->redirectToRoute('commande_index');
        }

    }

}
