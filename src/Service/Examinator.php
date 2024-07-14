<?php

namespace App\Service;

use App\Entity\Exam;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class Examinator implements ExaminatorInterface
{
    public function __construct(private EntityManagerInterface $entityManager, private  QuestionRepository $questionRepository)
    {
    }

    public function registerNewExam(Exam $exam) : void
    {
        $questions = $this->questionRepository->findAll();
        shuffle($questions);
        $data = [];

        foreach ($questions as $question) {
            $ans = $question->getAnswers()->toArray();
            shuffle($ans);

            $data[$question->getId()] = [
                'question' => $question->getQuestion(),
                'answers' => $ans
            ];
        }

        $exam
            ->setPoints(0)
            ->setCurrentQuestion(array_key_first($data))
            ->setOrderedQuestionsData($data);

        $this->entityManager->persist($exam);
        $this->entityManager->flush();
    }
}
