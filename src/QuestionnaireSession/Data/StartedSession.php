<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Data;

final class StartedSession
{
    /**
     * @param CompletedQuestionnaireQuestion[] $questions
     */
    public function __construct(
        public string $id,
        public array  $questions
    )
    {

    }
}
