<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\View;

use App\QuestionnaireSession\Entity\QuestionnaireSession;
use App\QuestionnaireSession\Exceptions\QuestionnaireSessionNotFoundException;
use App\QuestionnaireSession\Exceptions\QuestionnaireSessionStatusException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class QuestionnaireSessionViewFinder
{
    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface    $serializer,
    )
    {

    }

    public function load(string $sessionId): QuestionnaireSessionView
    {
        $correctAnswers = [];
        $incorrectAnswers = [];

        $session = $this->em->getRepository(QuestionnaireSession::class)->find($sessionId);

        if ($session === null) {
            throw QuestionnaireSessionNotFoundException::create($sessionId);
        }

        if ($session->status()->isCompleted() === false) {
            throw QuestionnaireSessionStatusException::notFinished($sessionId);
        }

        $questions = $session->content($this->serializer);

        foreach ($questions->questions as $question) {
            $allCorrectSelected = true;
            $anyIncorrectSelected = false;

            foreach ($question->options as $option) {
                if ($option->correct && !$option->selected) {
                    $allCorrectSelected = false;
                }

                if (!$option->correct && $option->selected) {
                    $anyIncorrectSelected = true;
                }
            }

            if ($allCorrectSelected && !$anyIncorrectSelected) {
                $correctAnswers[] = $question;
            } else {
                $incorrectAnswers[] = $question;
            }
        }

        return new QuestionnaireSessionView(
            id: $session->id(),
            createdAt: $session->createdAt(),
            correctAnswers: $correctAnswers,
            incorrectAnswers: $incorrectAnswers
        );
    }
}
