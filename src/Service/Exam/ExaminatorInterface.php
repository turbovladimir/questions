<?php

namespace App\Service\Exam;

use App\Entity\Exam;

interface ExaminatorInterface
{
    public function registerNewExam(Exam $exam) : void;

    public function registerAnswers(array $answerIds, Exam $exam) : void;
}
