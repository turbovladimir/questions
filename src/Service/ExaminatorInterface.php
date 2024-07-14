<?php

namespace App\Service;

use App\Entity\Exam;

interface ExaminatorInterface
{
    public function registerNewExam(Exam $exam) : void;
}
