<?php

namespace App\Entity;

use App\Repository\BorrowingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BorrowingRepository::class)]
class Borrowing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateborrowed = null;

    #[ORM\Column]
    private ?bool $bookreturned = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getDateborrowed(): ?\DateTimeInterface
    {
        return $this->dateborrowed;
    }

    public function setDateborrowed(\DateTimeInterface $dateborrowed): static
    {
        $this->dateborrowed = $dateborrowed;

        return $this;
    }

    public function isBookreturned(): ?bool
    {
        return $this->bookreturned;
    }

    public function setBookreturned(bool $bookreturned): static
    {
        $this->bookreturned = $bookreturned;

        return $this;
    }
}
