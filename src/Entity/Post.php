<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;    

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_autor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $texto;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_registro;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_update;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="post")
    */
    private $user;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->fecha_registro=new \DateTime();
        $this->fecha_update=new \DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getIdAutor(): ?int
    {
        return $this->id_autor;
    }

    public function setIdAutor(int $id_autor): self
    {
        $this->id_autor = $id_autor;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro(\DateTimeInterface $fecha_registro): self
    {
        $this->fecha_registro = $fecha_registro;

        return $this;
    }

    public function getFechaUpdate(): ?\DateTimeInterface
    {
        return $this->fecha_update;
    }

    public function setFechaUpdate(\DateTimeInterface $fecha_update): self
    {
        $this->fecha_update = $fecha_update;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

}
