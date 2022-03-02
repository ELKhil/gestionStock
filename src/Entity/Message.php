<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    private $firstName;
    private $lastName;
    private $birthDate;
    /**
     * @return string
     */
    #[Assert\Email]
    #[Assert\NotBlank]
    private $email;
    private $subject;

    #[Assert\NotBlank(message:'Ce champ est requis')]
    #[Assert\Length(min: 10, max: 10000,minMessage: 'Trop court', maxMessage : 'Trop long' )]
    private $content;


    private $accepter;
    private $genre;
    /*
     * @var UploadedFile
     */
    private $fichier;

    /**
     * @return mixed
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param mixed $fichier
     */
    public function setFichier($fichier): void
    {
        $this->fichier = $fichier;
    }




    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre): void
    {
        $this->genre = $genre;
    }


    /**
     * @return mixed
     */
    public function getAccepter()
    {
        return $this->accepter;
    }

    /**
     * @param mixed $accepter
     */
    public function setAccepter($accepter): void
    {
        $this->accepter = $accepter;
    }


    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }





    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }




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


    public function getSubject(): string
    {
        return $this->subject;
    }


    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }



}