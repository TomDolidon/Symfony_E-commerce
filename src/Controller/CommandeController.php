<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\EmpruntRepository;
use App\Repository\LecteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index( CommandeRepository $commandeRepository)
    {

        $user = $this->getUser();
        $commandes = $commandeRepository->findBy(["usager" => $user], ['date_commande' => 'DESC']);

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

}