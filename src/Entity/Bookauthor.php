<?php

namespace App\Entity;

use App\Repository\BookauthorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookauthorRepository::class)]
class Bookauthor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookId(): ?Book
    {
        return $this->book_id;
    }

    public function setBookId(?Book $book_id): static
    {
        $this->book_id = $book_id;

        return $this;
    }

    public function getAuthorId(): ?Author
    {
        return $this->author_id;
    }

    public function setAuthorId(?Author $author_id): static
    {
        $this->author_id = $author_id;

        return $this;
    }
}
