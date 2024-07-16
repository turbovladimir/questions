<?php

namespace App\Form\DTO;

class NextQuestionRequest
{
    private ?string $answerIds = null;


    /**
     * @param ?string $answerIds
     */
    public function setAnswerIds(?string $answerIds): void
    {
        $this->answerIds = $answerIds;
    }

    /**
     * @return array
     */
    public function getAnswerIds(): array
    {
        return $this->answerIds ?
            explode(',', $this->answerIds) :
            []
            ;
    }
}
