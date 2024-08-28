<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825161422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('create table if not exists questionnaire_template
(
    id            uuid                    not null constraint questionnaire_pk primary key,
    title         varchar(255)            not null,
    content       jsonb                   not null,
    created_at    timestamp default NOW() not null
);');

        $this->addSql('create table if not exists questionnaire_session
(
    id               uuid constraint questionnaire_session_pk primary key,
    questionnaire_template_id uuid  not null constraint questionnaire_session_questionnaire_id_fk references questionnaire_template,
    status           varchar not null,
    content          jsonb not null,
    created_at       timestamp default NOW() not null
);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS questionnaire_session');
        $this->addSql('DROP TABLE IF EXISTS questionnaire_template');
    }
}
