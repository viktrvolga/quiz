<?php

declare(strict_types=1);

namespace App\QuestionnaireTemplate\Data;

final class QuestionnaireTemplateQuestions implements \JsonSerializable
{
    /**
     * @param QuestionnaireTemplateQuestion[] $collection
     */
    public function __construct(
        public array $collection = []
    )
    {
    }

    public function jsonSerialize(): array
    {
        return ['collection' => $this->collection];
    }
}
