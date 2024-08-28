<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Data;

enum QuestionnaireSessionStatus: string
{
    case CREATED = 'created';
    case FINISHED = 'finished';

    public function isCompleted(): bool
    {
        return $this->name === self::FINISHED->name;
    }
}
