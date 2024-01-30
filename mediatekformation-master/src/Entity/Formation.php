<?php


namespace App\Entity;

use App\Repository\FormationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;

#[Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    private const CHEMINIMAGE = "https://i.ytimg.com/vi/";

    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private ?int $id = null;

    #[Column(type: "datetime", nullable: true)]
    #[Assert\NotBlank(message: "Veuillez indiquer la date de publication")]
    private ?DateTimeInterface $publishedAt = null;

    #[Column(type: "string", length: 100, nullable: true)]
    #[Assert\NotBlank(message: "Veuillez écrire un titre")]
    private ?string $title = null;

    #[Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[Column(type: "string", length: 20, nullable: true)]
    #[Assert\NotBlank(message: "Veuillez indiquer l'Id de la vidéo")]
    private ?string $videoId = null;

    #[ManyToOne(targetEntity: Playlist::class, inversedBy: "formations")]
    #[Assert\NotBlank(message: "Veuillez sélectionner une playlist")]
    private ?Playlist $playlist = null;

    #[ManyToMany(targetEntity: Categorie::class, inversedBy: "formations")]
    private Collection $categories;

    #[Column(type: "datetime", nullable: true)]
    #[Assert\NotBlank(message: "La date de création est obligatoire")]
    private ?DateTimeInterface $dateCreation = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): self
    {
        $this->videoId = $videoId;
        return $this;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): self
    {
        $this->playlist = $playlist;
        return $this;
    }

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }
    public function getPublishedAtString(): ?string
{
    if ($this->publishedAt === null) {
        return null;
    }

    return $this->publishedAt->format('Y-m-d H:i:s');
}

    public function getMiniature(): ?string
    {
        return self::CHEMINIMAGE . $this->videoId . "/default.jpg";
    }

    public function getPicture(): ?string
    {
        return self::CHEMINIMAGE . $this->videoId . "/hqdefault.jpg";
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);
        return $this;
    }
}
