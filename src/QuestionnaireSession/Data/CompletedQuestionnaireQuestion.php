<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Data;

final class CompletedQuestionnaireQuestion implements \JsonSerializable
{
    /**
     * @param CompletedQuestionnaireOption[] $options
     */
    public function __construct(
        public string $questionId,
        public string $questionText,
        public array  $options
    )
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'questionId' => $this->questionId,
            'questionText' => $this->questionText,
            'options' => $this->options,
        ];
    }

    public function refreshOptions(array $options): self
    {
        return new self(
            questionId: $this->questionId,
            questionText: $this->questionText,
            options: $options
        );
    }
}
