<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string',length : 8,unique: true,nullable: false)]
    private $reference;

    #[ORM\Column(type: 'string',length: 50 , nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50,min: 2)]
    private $nom;

    #[ORM\Column(type: 'string',length: 50, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50,min: 2)]
    private $prenom;

    #[ORM\Column(type: 'string',length: 255, nullable: false, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 255)]
    private $email;

    #[ORM\Column(type: 'string',length: 20, nullable: true)]
    #[Assert\Regex(pattern: '/^\+{0,1}\d+$/')]
    private $tel;

    #[ORM\Column(type: 'boolean',options: ["default" => 0])]
    private $deleted;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }


    public function getId(): ?int
    {
        return $this->id;
    }
}
