<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Data;

final class CompletedQuestionnaireOption implements \JsonSerializable
{
    public function __construct(
        public string $id,
        public string $text,
        public bool   $correct,
        public bool   $selected
    )
    {

    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'correct' => $this->correct,
            'selected' => $this->selected,
        ];
    }

    public function select(): self
    {
        return new self(
            id: $this->id,
            text: $this->text,
            correct: $this->correct,
            selected: true
        );
    }
}
