<?php

declare(strict_types=1);

namespace App\QuestionnaireSession;

use App\QuestionnaireSession\Data\CompletedQuestionnaire;
use App\QuestionnaireSession\Data\StartedSession;
use App\QuestionnaireSession\Exceptions\QuestionnaireSessionStatusException;
use App\QuestionnaireSession\Exceptions\QuestionnaireSessionNotFoundException;
use App\QuestionnaireTemplate\Entity\QuestionnaireTemplate;
use App\QuestionnaireSession\Entity\QuestionnaireSession;
use App\QuestionnaireSession\Exceptions\QuestionnaireTemplateNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Serializer\SerializerInterface;

final class QuestionnaireSessionProvider
{
    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface    $serializer
    )
    {
    }

    public function start(string $questionnaireId): StartedSession
    {
        $questionnaire = $this->em->getRepository(QuestionnaireTemplate::class)->find($questionnaireId);

        if ($questionnaire === null) {
            throw QuestionnaireTemplateNotFoundException::create($questionnaireId);
        }

        $clearQuestionnaire = CompletedQuestionnaire::raw(
            templateQuestions: $questionnaire->questions($this->serializer),
            randomOrder: true
        );

        $session = QuestionnaireSession::new(
            questionnaire: $questionnaire,
            clearQuestionnaire: $clearQuestionnaire
        );

        $this->em->persist($session);
        $this->em->flush();

        return new StartedSession(
            id: $session->id(),
            questions: $clearQuestionnaire->questions
        );
    }

    public function finalize(string $sessionId, ParameterBag $parameters): void
    {
        $sessionRepository = $this->em->getRepository(QuestionnaireSession::class);
        $session = $sessionRepository->find($sessionId);

        if ($session === null) {
            throw QuestionnaireSessionNotFoundException::create($sessionId);
        }

        if ($session->status()->isCompleted()) {
            throw QuestionnaireSessionStatusException::alreadyFinished($sessionId);
        }

        $questionnaire = $session->content($this->serializer);
        $updatedAnswers = $questionnaire->applyAnswers($parameters->all());

        $session->updateQuestionnaire($updatedAnswers);

        $this->em->flush();
    }
}
