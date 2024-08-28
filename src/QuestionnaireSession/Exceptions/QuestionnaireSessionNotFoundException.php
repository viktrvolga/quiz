<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Exceptions;

final class QuestionnaireSessionNotFoundException extends \InvalidArgumentException
{
    public static function create(string $id): self
    {
        return new self(\sprintf('Unable to find questionnaire session with ID `%s`', $id));
    }
}
