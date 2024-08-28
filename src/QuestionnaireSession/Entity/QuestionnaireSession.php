<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Entity;

use App\QuestionnaireSession\Data\CompletedQuestionnaire;
use App\QuestionnaireSession\Data\QuestionnaireSessionStatus;
use App\QuestionnaireTemplate\Entity\QuestionnaireTemplate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @todo: custom type for enum
 */
#[ORM\Entity]
class QuestionnaireSession
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\ManyToOne(targetEntity: QuestionnaireTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private QuestionnaireTemplate $questionnaireTemplate;

    #[ORM\Column]
    private string $status;

    #[ORM\Column]
    private string $content;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public static function new(QuestionnaireTemplate $questionnaire, CompletedQuestionnaire $clearQuestionnaire): self
    {
        return new self(
            id: Uuid::v4()->toString(),
            questionnaire: $questionnaire,
            content: \json_encode($clearQuestionnaire),
            createdAt: new \DateTimeImmutable()
        );
    }

    public function updateQuestionnaire(CompletedQuestionnaire $filledQuestionnaire): void
    {
        $this->content = \json_encode($filledQuestionnaire);
        $this->status = QuestionnaireSessionStatus::FINISHED->value;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function status(): QuestionnaireSessionStatus
    {
        return QuestionnaireSessionStatus::from($this->status);
    }

    public function questionnaireTemplate(): QuestionnaireTemplate
    {
        return $this->questionnaireTemplate;
    }

    public function content(SerializerInterface $serializer): CompletedQuestionnaire
    {
        return $serializer->deserialize($this->content, CompletedQuestionnaire::class, 'json');
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    private function __construct(
        string                $id,
        QuestionnaireTemplate $questionnaire,
        string                $content,
        \DateTimeImmutable    $createdAt)
    {
        $this->id = $id;
        $this->questionnaireTemplate = $questionnaire;
        $this->content = $content;
        $this->status = QuestionnaireSessionStatus::CREATED->value;
        $this->createdAt = $createdAt;
    }
}
