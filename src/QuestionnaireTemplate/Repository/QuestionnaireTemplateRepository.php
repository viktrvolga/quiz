<?php

declare(strict_types=1);

namespace App\QuestionnaireTemplate\Repository;

use App\QuestionnaireTemplate\Entity\QuestionnaireTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class QuestionnaireTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, QuestionnaireTemplate::class);
    }
}
