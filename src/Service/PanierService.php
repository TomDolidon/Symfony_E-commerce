<?php

// src/Service/PanierService.php
namespace App\Service;

use App\Entity\Commande;
use App\Entity\Emprunt;
use App\Entity\LigneCommande;
use App\Entity\Usager;
use App\Repository\LecteurRepository;
use App\Repository\ProduitRepository;
use Cassandra\Date;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\BoutiqueService;

// Service pour manipuler le panier et le stocker en session
class PanierService
{
    ////////////////////////////////////////////////////////////////////////////
    const PANIER_SESSION = 'panier'; // Le nom de la variable de session du panier
    private $session;  // Le service Session
    private $boutique; // Le service Boutique
    private $panier;   // Tableau associatif idProduit => quantite
    private $em;
    private $pr;

    // constructeur du service
    public function __construct(SessionInterface $session, BoutiqueService $boutique, EntityManagerInterface $em, ProduitRepository $pr)
    {
        // Récupération des services session et BoutiqueService
        $this->boutique = $boutique;
        $this->session = $session;
        // Récupération du panier en session s'il existe, init. à vide sinon
        $this->panier = $session->get(self::PANIER_SESSION, array());
        $this->em = $em;
        $this->pr = $pr;

    }

    // getContenu renvoie le contenu du panier
    //  tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu()
    {
        return $this->panier;
    }

    // getTotal renvoie le montant total du panier
    public function getTotal()
    {
        $total = 0;

        foreach ($this->panier as $product) {
            $total += $product['produit']->getPrix() * $product['quantite'];
        }

        return $total;

    }

    // getNbProduits renvoie le nombre de produits dans le panier
    public function getNbProduits()
    {
        $nbProduit = 0;

        foreach ($this->panier as $product) {
           $nbProduit += $product['quantite'];
        }

        return $nbProduit;

    }

    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
    public function ajouterProduit(int $idProduit, int $quantite = 1)
    {

        $isFind = false;

        foreach ($this->panier as &$product) {

            if ($product['produit']->getId() == $idProduit) {
                $product['quantite'] += $quantite;
                $isFind = true;
            }
        }

        if (!$isFind) {
            array_push($this->panier, ['produit' => $this->pr->find($idProduit), 'quantite' => $quantite]);
        }

        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public function enleverProduit(int $idProduit, int $quantite = 1)
    {

        foreach ($this->panier as $productKey => &$lignePanier) {
            if ($lignePanier['produit']->getId() == $idProduit) {
                $lignePanier['quantite'] -= $quantite;

                if ($lignePanier['quantite'] == 0) {
                    $this->supprimerProduit($lignePanier['produit']->getId());
                }
            }
        }

        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // supprimerProduit supprime complètement le produit $idProduit du panier
    public function supprimerProduit(int $idProduit)
    {

        foreach($this->panier as $productKey => $lignePanier) {
                if($lignePanier['produit']->getId() == $idProduit){
                    array_splice($this->panier, $productKey, 1);
            }
        }

        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // vider vide complètement le panier
    public function vider()
    { // à compléter
        $this->panier = array();
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    public function panierToCommande(Usager $usager) {

        $commande = new Commande($usager);
        $this->em->persist($commande);
        $commande->setDateCommande(new \DateTime());
        $commande->setStatut("en Cours");


        foreach($this->panier as  $lignePanier) {
            dump($lignePanier['produit']);
             $ligneCommande = new LigneCommande( $lignePanier['quantite'] );
            $this->em->persist($ligneCommande);

          //   $ligneCommande->setIdArticle($lignePanier['produit']);
            $ligneCommande->setArticle($this->pr->find($lignePanier['produit']->getId()));

             $ligneCommande->setCommande($commande);
             $ligneCommande->setPrix($lignePanier['produit']->getPrix());
            $commande->addLigneCommande($ligneCommande);
        }

        $this->em->flush();
        $this->vider();

        return $commande;

    }

}
