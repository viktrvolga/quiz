<?php

declare(strict_types=1);

namespace App\QuestionnaireTemplate\Data;

final class QuestionnaireTemplateQuestion implements \JsonSerializable
{
    /**
     * @param QuestionnaireTemplateAnswer[] $choices
     */
    public function __construct(
        public string $id,
        public string $text,
        public array  $choices
    )
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'choices' => $this->choices,
        ];
    }
}
