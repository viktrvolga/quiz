<?php

declare(strict_types=1);

namespace App\QuestionnaireSession\Data;

use App\QuestionnaireTemplate\Data\QuestionnaireTemplateAnswer;
use App\QuestionnaireTemplate\Data\QuestionnaireTemplateQuestion;
use App\QuestionnaireTemplate\Data\QuestionnaireTemplateQuestions;

final class CompletedQuestionnaire implements \JsonSerializable
{
    public static function raw(QuestionnaireTemplateQuestions $templateQuestions, bool $randomOrder): self
    {
        $questions = $templateQuestions->collection;

        if ($randomOrder === true) {
            \shuffle($questions);
        }

        return new self(
            questions: \array_map(
                static function (QuestionnaireTemplateQuestion $templateQuestion) use ($randomOrder) {
                    $choices = $templateQuestion->choices;

                    if ($randomOrder === true) {
                        \shuffle($choices);
                    }

                    return new CompletedQuestionnaireQuestion(
                        questionId: $templateQuestion->id,
                        questionText: $templateQuestion->text,
                        options: \array_map(
                            static function (QuestionnaireTemplateAnswer $templateAnswer): CompletedQuestionnaireOption {
                                return new CompletedQuestionnaireOption(
                                    id: $templateAnswer->id,
                                    text: $templateAnswer->text,
                                    correct: $templateAnswer->isCorrect,
                                    selected: false
                                );
                            },
                            $choices
                        )
                    );
                },
                $questions
            )
        );
    }

    /**
     * @param CompletedQuestionnaireQuestion[] $questions
     */
    public function __construct(
        public array $questions
    )
    {

    }

    public function applyAnswers(array $answers): self
    {
        $result = [];

        foreach ($this->questions as $originalQuestion) {
            $modifiedOptions = [];
            $questionAnswers = $answers[$originalQuestion->questionId] ?? [];

            foreach ($originalQuestion->options as $option) {
                if (\in_array($option->id, $questionAnswers, true)) {
                    $modifiedOptions[] = $option->select();
                } else {
                    $modifiedOptions[] = $option;
                }
            }

            $result[] = $originalQuestion->refreshOptions($modifiedOptions);
        }

        return new self($result);
    }

    public function jsonSerialize(): array
    {
        return ['questions' => $this->questions];
    }
}
