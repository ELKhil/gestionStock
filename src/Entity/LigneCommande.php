<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer',nullable: false)]
    private $quantite;

    #[ORM\Column(type: 'decimal',precision: 7, scale: 2, nullable: true)]
    private $prix;

    #[ORM\ManyToOne(targetEntity:'App\Entity\Commande', inversedBy: 'lignes')]
    #[ORM\JoinColumn(onDelete: 'NO ACTION',nullable: false )]
    private $commande;

    #[ORM\ManyToOne(targetEntity:'App\Entity\Produit')]
    #[ORM\JoinColumn(onDelete: 'NO ACTION',nullable: false )]
    private $produit_id;

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix): void
    {
        $this->prix = $prix;
    }





    /**
     * @return mixed
     */
    public function getProduitId()
    {
        return $this->produit_id;
    }

    /**
     * @param mixed $produit_id
     */
    public function setProduitId($produit_id): void
    {
        $this->produit_id = $produit_id;
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande): void
    {
        $this->commande = $commande;
    }





    public function getId(): ?int
    {
        return $this->id;
    }
}
