<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Service\DeviseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\BoutiqueService;
use Symfony\Component\HttpFoundation\Request;

class BoutiqueController extends AbstractController
{

    /**
     * @Route("/boutique", name="boutique")
     */
    public function index(CategorieRepository $categorieRepository)
    {
        return $this->render('boutique/index.html.twig',
            [
                'categories' => $categorieRepository->findAll(),
            ]
            );
    }

    public function rayon(ProduitRepository $produitRepository, DeviseService $deviseService,  int $idCategorie)
    {
        $produits = $produitRepository->findBy(
            ['categorie' => $idCategorie]
        );

        return $this->render('boutique/rayon.html.twig',
            [
                "produits" => $produits,
                "devise" => $deviseService->getStringDevise()
            ]
        );
    }

    public function search(BoutiqueService $boutique, Request $request, DeviseService $deviseService)
    {
        $value = $request->query->get('searchProduct');

        $produits = $boutique->findProduitsByLibelleOrTexte($value);

        return $this->render('boutique/search.html.twig',
            [
                "produits" => $produits,
                "devise" => $deviseService->getStringDevise()
            ]
        );
    }
}
