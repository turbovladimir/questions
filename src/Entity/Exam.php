<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

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
    private array $orderedQuestionsData = [];

    #[ORM\Column]
    private int $currentQuestionNumber = 0;

    #[ORM\Column(length: 50)]
    private ?string $userName = null;

    /**
     * @var Collection<int, Result>
     */
    #[ORM\OneToMany(targetEntity: Result::class, mappedBy: 'exam')]
    private Collection $results;

    public function __construct()
    {
        $this->addedAt = new \DateTimeImmutable();
        $this->results = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedAt(): ?\DateTimeImmutable
    {
        return $this->addedAt;
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

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @param int $currentQuestionNumber
     */
    public function setCurrentQuestionNumber(int $currentQuestionNumber): void
    {
        $this->currentQuestionNumber = $currentQuestionNumber;
    }

    /**
     * @return int|null
     */
    public function getCurrentQuestionNumber(): ?int
    {
        return $this->currentQuestionNumber;
    }

    public function nextQuestion() : static
    {
        $this->currentQuestionNumber++;

        if ($this->currentQuestionNumber > count($this->orderedQuestionsData)) {
            $this->currentQuestionNumber = 0;
        }

        return $this;
    }

    public function isFinished() : bool
    {
        return $this->currentQuestionNumber === 0;
    }

    public function getQuestionData() : array
    {
        return $this->orderedQuestionsData[$this->currentQuestionNumber];
    }

    /**
     * @return Collection<int, Result>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): static
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setExam($this);
        }

        return $this;
    }

    public function removeResult(Result $result): static
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getExam() === $this) {
                $result->setExam(null);
            }
        }

        return $this;
    }
}
