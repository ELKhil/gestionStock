<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
#[ORM\UniqueConstraint(name: 'fullNmae', columns: ['nom','prenom'])]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string',length: 100, nullable: false)]
    private $nom;

    #[ORM\Column(type: 'string',length: 100,nullable: false)]
    private $prenom;

    #[ORM\Column(type: 'date',nullable: true)]
    private $dateDeNaissance;

    #[ORM\Column(type: 'boolean',nullable: false, options: ["default"=> 0] )]
    private $estPrime;

    #[ORM\Column(type: 'text',length: 1000, nullable: true)]
    private $bibliographie;





    private $full_name;

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * @param mixed $dateDeNaissance
     */
    public function setDateDeNaissance($dateDeNaissance): void
    {
        $this->dateDeNaissance = $dateDeNaissance;
    }

    /**
     * @return mixed
     */
    public function getEstPrime()
    {
        return $this->estPrime;
    }

    /**
     * @param mixed $estPrime
     */
    public function setEstPrime($estPrime): void
    {
        $this->estPrime = $estPrime;
    }

    /**
     * @return mixed
     */
    public function getBibliographie()
    {
        return $this->bibliographie;
    }

    /**
     * @param mixed $bibliographie
     */
    public function setBibliographie($bibliographie): void
    {
        $this->bibliographie = $bibliographie;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name): void
    {
        $this->full_name = $full_name;
    }




    public function getId(): ?int
    {
        return $this->id;
    }
}
