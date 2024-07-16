<?php

namespace App\Service\Exam;

use App\Entity\Exam;
use App\Entity\Result;
use App\Repository\ExamRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class Examinator implements ExaminatorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private  QuestionRepository $questionRepository,
        private ExamRepository $examRepository,
        private SerializerInterface $serializer
    )
    {
    }

    public function registerNewExam(Exam $exam) : void
    {
        $existExam = $this->examRepository->findOneBy(['userName' => $exam->getUserName()]);

        if ($existExam) {
            $this->entityManager->remove($existExam);
            $this->entityManager->remove($existExam->getResults());
        }

        $questions = $this->questionRepository->findAll();

        if (empty($questions)) {
            throw new \LogicException('Приложение не проинициализированно.');
        }

        shuffle($questions);
        $ordered = [];
        $questionNumber = 1;
        $exam->setCurrentQuestionNumber($questionNumber);

        foreach ($questions as $question) {
            $ordered[$questionNumber++] = $this->serializer->normalize($question, context: ['groups' => 'group1']);
        }

        $this->entityManager->persist($exam->setOrderedQuestionsData($ordered));
        $this->entityManager->flush();
    }

    public function registerAnswers(array $answerIds, Exam $exam) : void
    {
        $r = new Result();
        $exam->addResult($r);
        $hasWrongAnswers = false;
        $q = $exam->getQuestionData();

        if (empty($answerIds)) {
            $hasWrongAnswers = true;
        } else {
            foreach ($q['answers'] as $answer) {
                if (!$answer['isRightAnswer'] && in_array($answer['id'], $answerIds)) {
                    $hasWrongAnswers = true;
                }
            }
        }

        $r->setQuestion($q['question'])
            ->setFailed($hasWrongAnswers);
        $this->entityManager->persist($r);
        $this->entityManager->persist($exam->nextQuestion());
        $this->entityManager->flush();
    }
}
