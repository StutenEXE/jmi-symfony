<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id_nom = null;

    #[ORM\Id]
    #[ORM\Column]
    private ?int $id_contact = null;

    public function getIdNom(): ?int
    {
        return $this->id_nom;
    }

    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    public function setIdContact(?Utilisateur $id_contact): self
    {
        $this->id_contact = $id_contact;

        return $this;
    }
}
