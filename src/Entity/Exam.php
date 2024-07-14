<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamRepository::class)]
class Exam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $addetAt = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column]
    private array $questionsOrder = [];

    #[ORM\Column]
    private ?int $currentQuestion = null;

    #[ORM\Column(length: 50)]
    private ?string $userName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddetAt(): ?\DateTimeImmutable
    {
        return $this->addetAt;
    }

    public function setAddetAt(\DateTimeImmutable $addetAt): static
    {
        $this->addetAt = $addetAt;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getQuestionsOrder(): array
    {
        return $this->questionsOrder;
    }

    public function setQuestionsOrder(array $questionsOrder): static
    {
        $this->questionsOrder = $questionsOrder;

        return $this;
    }

    public function getCurrentQuestion(): ?int
    {
        return $this->currentQuestion;
    }

    public function setCurrentQuestion(int $currentQuestion): static
    {
        $this->currentQuestion = $currentQuestion;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }
}
