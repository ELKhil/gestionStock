<?php

namespace App\Entity;

use App\Entity\Client;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10 , nullable: false)]
    private $reference;

    #[ORM\Column(type: 'date',nullable: false)]
    private $updateDate;

    #[ORM\Column(type: 'date',nullable: false)]

    private $creationDate;

    #[ORM\Column(type: 'smallint',nullable: false)]
    private $etat;

    //cascade: ['persist'] permet de sauvegarder une commande et un client en meme temps
    #[ORM\ManyToOne(targetEntity:'App\Entity\Client')]
    #[ORM\JoinColumn(onDelete: 'NO ACTION', nullable: false )]
    private $client;

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /*
     * @var LigneCommande[]
     *
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\LigneCommande' , mappedBy: 'commande')]
    private $lignes;

    /**
     * @param $lignes
     */
    public function __construct()
    {
        $this->lignes = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param
     */
    public function setUpdateDate($updateDate): void
    {
        $this->updateDate = $updateDate;
    }

    /**
     * @return
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param
     */
    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getLignes()
    {
        return $this->lignes;
    }

    /**
     * @param mixed $lignes
     */
    public function setLignes($lignes): void
    {
        $this->lignes = $lignes;
    }



    public function getId(): ?int
    {
        return $this->id;
    }


    public function addLigne(LigneCommande $ligne){
        $this->lignes->add($ligne);
    }
    public function removeLigne (LigneCommande $ligne){
        $this->lignes->remove($ligne);
    }



}
