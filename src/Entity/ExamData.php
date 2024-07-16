<?php

namespace App\Entity;

class ExamData
{
    public function __construct(private int $questionId, private string $question, private array $answers)
    {
    }

    /**
     * @return int
     */
    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }
}
