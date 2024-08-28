<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Controller;

use App\QuestionnaireSession\Exceptions\QuestionnaireSessionStatusException;
use App\QuestionnaireSession\Exceptions\QuestionnaireSessionNotFoundException;
use App\QuestionnaireSession\Exceptions\QuestionnaireTemplateNotFoundException;
use App\QuestionnaireSession\QuestionnaireSessionProvider;
use App\QuestionnaireSession\View\QuestionnaireSessionViewFinder;
use App\QuestionnaireTemplate\Repository\QuestionnaireTemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class QuestionnaireSessionController extends AbstractController
{
    #[Route('/quiz', name: 'quiz_welcome')]
    public function start(QuestionnaireTemplateRepository $questionnaireRepository): Response
    {
        return $this->render('quiz_start.html.twig', [
            'available' => $questionnaireRepository->findAll(),
        ]);
    }

    #[Route('/quiz/start/{questionnaireId}', name: 'quiz_start')]
    public function quiz(
        string                       $questionnaireId,
        QuestionnaireSessionProvider $sessionProvider
    ): Response
    {
        try {
            $sessionData = $sessionProvider->start($questionnaireId);

            return $this->render('quiz_form.html.twig', [
                'id' => $sessionData->id,
                'questions' => $sessionData->questions
            ]);
        } catch (QuestionnaireTemplateNotFoundException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
    }

    #[Route('/quiz/process/{sessionId}', name: 'quiz_process', methods: ['POST'])]
    public function process(
        string                       $sessionId,
        QuestionnaireSessionProvider $sessionProvider,
        Request                      $request
    ): Response
    {
        try {
            $sessionProvider->finalize($sessionId, $request->request);

            return $this->redirect($this->generateUrl('quiz_report', ['sessionId' => $sessionId]));
        } catch (QuestionnaireSessionNotFoundException|QuestionnaireSessionStatusException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
    }

    #[Route('/quiz/{sessionId}', name: 'quiz_report')]
    public function view(string $sessionId, QuestionnaireSessionViewFinder $viewFinder): Response
    {
        $sessionView = $viewFinder->load($sessionId);

        return $this->render('quiz_results.html.twig', [
            'correctQuestions' => $sessionView->correctAnswers,
            'incorrectQuestions' => $sessionView->incorrectAnswers,
        ]);
    }
}
