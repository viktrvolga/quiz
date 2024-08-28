<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\View;

final class QuestionnaireSessionView
{
    public function __construct(
        public string             $id,
        public \DateTimeImmutable $createdAt,
        public array              $correctAnswers,
        public array              $incorrectAnswers,
    )
    {

    }
}
