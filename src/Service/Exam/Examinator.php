<?php

namespace App\Service\Exam;

use App\Entity\Answer;
use App\Entity\Exam;
use App\Repository\AnswerRepository;
use App\Repository\ExamRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class Examinator implements ExaminatorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private  QuestionRepository $questionRepository,
        private AnswerRepository $answerRepository,
        private ExamRepository $examRepository
    )
    {
    }

    public function registerNewExam(Exam $exam) : void
    {
        $existExam = $this->examRepository->findOneBy(['userName' => $exam->getUserName()]);

        if ($existExam) {
            $this->entityManager->remove($existExam);
        }

        $questions = $this->questionRepository->findAll();

        if (empty($questions)) {
            throw new \LogicException('Приложение не проинициализированно.');
        }

        shuffle($questions);
        $data = [];
        $questionNumber = 1;
        $exam->setCurrentQuestionNumber($questionNumber);

        foreach ($questions as $question) {
            $ans = $question->getAnswers()
                ->map(fn(Answer $answer) => [
                    'id' => $answer->getId(),
                    'value' => $answer->getAnswer()
                ])->toArray();
            shuffle($ans);

            $data[$questionNumber++] = [
                'question_id' => $question->getId(),
                'question' => $question->getQuestion(),
                'answers' => $ans
            ];
        }

        $this->entityManager->persist($exam->setOrderedQuestionsData($data));
        $this->entityManager->flush();
    }

    public function registerAnswers(array $answerIds, Exam $exam) : void
    {
        $rightAnswersCnt = $this->answerRepository->count(['id' => $answerIds, 'isRightAnswer' => true]);
        $exam
            ->addPoints($rightAnswersCnt)
            ->nextQuestion()
        ;
        $this->entityManager->persist($exam);
        $this->entityManager->flush();
    }

    public function getQuestion(Exam $exam) : array
    {
        $examData = $exam->getOrderedQuestionsData();

        return $examData[$exam->getCurrentQuestionNumber()];
    }
}
