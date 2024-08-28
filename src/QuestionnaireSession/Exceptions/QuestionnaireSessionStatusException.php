<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Exceptions;

final class QuestionnaireSessionStatusException extends \InvalidArgumentException
{
    public static function alreadyFinished(string $id): self
    {
        return new self(\sprintf('Questionnaire session with ID `%s` was finished', $id));
    }

    public static function notFinished(string $id): self
    {
        return new self(\sprintf('Questionnaire session with ID `%s` not finished yet', $id));
    }
}
