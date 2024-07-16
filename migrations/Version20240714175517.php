<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240714175517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE exam_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE result_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE answer (id INT NOT NULL, question_id INT NOT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, answer VARCHAR(255) NOT NULL, is_right_answer BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('COMMENT ON COLUMN answer.added_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE exam (id INT NOT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ordered_questions_data JSON NOT NULL, current_question_number INT NOT NULL, user_name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN exam.added_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, question VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN question.added_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE result (id INT NOT NULL, exam_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, is_failed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_136AC113578D5E91 ON result (exam_id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113578D5E91 FOREIGN KEY (exam_id) REFERENCES exam (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE exam_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE result_id_seq CASCADE');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE result DROP CONSTRAINT FK_136AC113578D5E91');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE result');
    }
}
