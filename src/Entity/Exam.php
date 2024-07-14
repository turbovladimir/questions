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
    private ?\DateTimeImmutable $addedAt = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column]
    private array $orderedQuestionsData = [];

    #[ORM\Column]
    private ?int $currentQuestion = null;

    #[ORM\Column(length: 50)]
    private ?string $userName = null;

    public function __construct()
    {
        $this->addedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedAt(): ?\DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeImmutable $addedAt): static
    {
        $this->addedAt = $addedAt;

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

    public function getOrderedQuestionsData(): array
    {
        return $this->orderedQuestionsData;
    }


    public function setOrderedQuestionsData(array $orderedQuestionsData): static
    {
        $this->orderedQuestionsData = $orderedQuestionsData;

        return $this;
    }

    public function getCurrentQuestionData(): array
    {
        return $this->orderedQuestionsData[$this->currentQuestion] ?? [];
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
