<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\QuestionnaireTemplate\Data\QuestionnaireTemplateAnswer;
use App\QuestionnaireTemplate\Data\QuestionnaireTemplateQuestion;
use App\QuestionnaireTemplate\Data\QuestionnaireTemplateQuestions;
use App\QuestionnaireTemplate\Entity\QuestionnaireTemplate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class QuestionnaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $questions = [
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '1 + 1 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '3',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '2',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '0',
                        isCorrect: false
                    )
                ]
            ),
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '2 + 2 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '4',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '3 + 1',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '10',
                        isCorrect: false
                    )
                ]
            ),
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '3 + 3 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '1 + 5',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '1',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '6',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '2 + 4',
                        isCorrect: true
                    )
                ]
            ),
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '4 + 4 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '8',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '4',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '0',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '0 + 8',
                        isCorrect: true
                    )
                ]
            ),
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '5 + 5 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '6',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '18',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '10',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '9',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '0',
                        isCorrect: false
                    )
                ]
            ),
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '6 + 6 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '3',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '9',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '0',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '12',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '5 + 7',
                        isCorrect: true
                    )
                ]
            ),
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '7 + 7 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '5',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '14',
                        isCorrect: true
                    )
                ]
            ),
            new QuestionnaireTemplateQuestion(
                id: Uuid::v4()->toString(),
                text: '8 + 8 = ?',
                choices: [
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '16',
                        isCorrect: true
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '12',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '9',
                        isCorrect: false
                    ),
                    new QuestionnaireTemplateAnswer(
                        id: Uuid::v4()->toString(),
                        text: '5',
                        isCorrect: false
                    )
                ]
            )
        ];

        $questionnaire = QuestionnaireTemplate::create(
            title: 'Assessment',
            questions: new QuestionnaireTemplateQuestions($questions)
        );

        $manager->persist($questionnaire);
        $manager->flush();
    }
}
