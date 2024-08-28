<?php

declare(strict_types=1);

namespace App\QuestionnaireTemplate\Data;

final class QuestionnaireTemplateAnswer implements \JsonSerializable
{
    public function __construct(
        public string $id,
        public string $text,
        public bool   $isCorrect
    )
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'isCorrect' => $this->isCorrect,
        ];
    }
}
