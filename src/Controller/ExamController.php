<?php

namespace App\Controller;

use App\Entity\Exam;
use App\Enums\SessionLabels;
use App\Form\StartExamActionType;
use App\Repository\ExamRepository;
use App\Service\ExaminatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exam', name: 'exam_')]
class ExamController extends AbstractController
{
    #[Route('/start', name: 'start')]
    public function index(Request $request, ExaminatorInterface $examinator): Response
    {
        $exam = new Exam();
        $form = $this->createForm(StartExamActionType::class, $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $examinator->registerNewExam($exam);
            $request->getSession()->set(SessionLabels::UserName->value, $exam->getUserName());
        }

        return $this->render('exam/start/index.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/question/show', name: 'question_show')]
    public function questionShow(Request $request, EntityManagerInterface $entityManager, ExamRepository $examRepository): Response
    {
        $exam = $examRepository->findOneBy(['userName' => $request->getSession()->get(SessionLabels::UserName->value)]);

        if (!$exam) {
            return $this->redirectToRoute('exam_start');
        }

        $form = null;

        return $this->render('exam/question/show/index.html.twig', [
            'question_data' => $exam->getCurrentQuestionData(),
            'form' => $form
        ]);
    }
}
