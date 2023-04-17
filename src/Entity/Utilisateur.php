<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_nom = null;

    #[ORM\Column]
    private ?string $nom = null;

    #[ORM\Column]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?string $num = null;

    #[ORM\Column]
    private ?string $email = null;

    public function getIdNom(): ?int
    {
        return $this->id_nom;
    }

//    public function __construct($setnom, $setprenom, $setnum, $setemail) {
//        $this->nom = $setnom;
//        $this->prenom =  $setprenom;
//        $this->email = $setemail;
//        $this->num = $setnum;
//    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setNom(?string $nom)
    {
        $this->nom = $nom;
    }

    public function setPrenom(?string $prenom)
    {
        $this->prenom = $prenom;
    }

    public function setNum(?string $num)
    {
        $this->num = $num;
    }
    
    public function setEmail(?string $email)
    {
        $this->email =$email;
    }
}