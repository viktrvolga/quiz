<?php

declare(strict_types=1);

namespace App\QuestionnaireTemplate\Entity;

use App\QuestionnaireTemplate\Data\QuestionnaireTemplateQuestions;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class QuestionnaireTemplate
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $title;

    #[ORM\Column]
    private string $content;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public static function create(string $title, QuestionnaireTemplateQuestions $questions): self
    {
        return new self(
            id: Uuid::v4()->toString(),
            title: $title,
            content: \json_encode($questions),
            createdAt: new \DateTimeImmutable()
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function questions(SerializerInterface $serializer): QuestionnaireTemplateQuestions
    {
        return $serializer->deserialize(
            $this->content,
            QuestionnaireTemplateQuestions::class,
            'json'
        );
    }

    private function __construct(
        string             $id,
        ?string            $title,
        string             $content,
        \DateTimeImmutable $createdAt
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }
}
