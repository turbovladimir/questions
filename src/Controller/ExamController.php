<?php

namespace App\Controller;

use App\Entity\Exam;
use App\Enums\SessionLabels;
use App\Form\DTO\NextQuestionRequest;
use App\Form\NextQuestionType;
use App\Form\StartExamActionType;
use App\Repository\ExamRepository;
use App\Service\Exam\ExaminatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

#[Route('/exam', name: 'exam_')]
class ExamController extends AbstractController
{
    #[Route('/start', name: 'start')]
    public function start(Request $request, ExaminatorInterface $examinator): Response
    {
        $exam = new Exam();
        $form = $this->createForm(StartExamActionType::class, $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $examinator->registerNewExam($exam);
            $request->getSession()->set(SessionLabels::UserName->value, $exam->getUserName());

            return $this->redirectToRoute('exam_question_show');
        }

        return $this->render('exam/start/index.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/question/show', name: 'question_show')]
    public function questionShow(
        Request $request,
        ExamRepository $examRepository,
        ExaminatorInterface $examinator
    ): Response
    {
        if (!$this->examIsStarted($request)) {
            return $this->redirectToRoute('exam_start');
        }

        $exam = $examRepository->findOneBy(['userName' => $request->getSession()->get(SessionLabels::UserName->value)]);

        if (!$exam) {
            return $this->redirectToRoute('exam_start');
        }

        if ($exam->isFinished()) {
            return $this->redirectToRoute('exam_finish');
        }

        $dto = new  NextQuestionRequest();
        $form = $this->createForm(NextQuestionType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $examinator->registerAnswers($dto->getAnswerIds(), $exam);

            return $this->redirectToRoute('exam_question_show');
        }


        return $this->render('exam/question/show/index.html.twig', [
            'question' => $exam->getQuestionData(),
            'question_number' => $exam->getCurrentQuestionNumber(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/finish', name: 'finish')]
    public function finish(ExamRepository $examRepository, Request $request) : Response
    {
        if (!$this->examIsStarted($request)) {
            return $this->redirectToRoute('exam_start');
        }

        $exam = $examRepository->findOneBy(['userName' => $request->getSession()->get(SessionLabels::UserName->value)]);

        if (!$exam->isFinished()) {
            return $this->redirectToRoute('exam_question_show');
        }


        return  $this->render('exam/finish/index.html.twig', [
            'results' => $exam->getResults()
        ]);
    }

    private function examIsStarted(Request $request) : bool
    {
        return $request->getSession()->has(SessionLabels::UserName->value);
    }
}
