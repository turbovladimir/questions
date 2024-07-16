<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240714190628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
insert into question (id, added_at, question) values
                                                  (nextval('question_id_seq'), now(), '1+1'),
                                                  (nextval('question_id_seq'), now(), '2+2'),
                                                  (nextval('question_id_seq'), now(), '3+3'),
                                                  (nextval('question_id_seq'), now(), '4+4'),
                                                  (nextval('question_id_seq'), now(), '5+5'),
                                                  (nextval('question_id_seq'), now(), '6+6'),
                                                  (nextval('question_id_seq') , now(),'7+7'),
                                                  (nextval('question_id_seq'), now(), '8+8'),
                                                  (nextval('question_id_seq'), now(), '9+9'),
                                                  (nextval('question_id_seq') , now(),'10+10');
        ");
        $this->addSql("
insert into answer (id, question_id, added_at, answer, is_right_answer) values
                                                                        (nextval('answer_id_seq'), 1, now(), '3', false),
                                                                        (nextval('answer_id_seq'), 1, now(), '2', true),
                                                                        (nextval('answer_id_seq') , 1, now(), '0', false),

                                                                        (nextval('answer_id_seq'), 2, now(), '4', true),
                                                                        (nextval('answer_id_seq'), 2, now(), '3 + 1', true),
                                                                        (nextval('answer_id_seq'), 2, now(), '10', false),

                                                                        (nextval('answer_id_seq'), 3, now(), '1 + 5', true),
                                                                        (nextval('answer_id_seq'), 3, now(), '1', false),
                                                                        (nextval('answer_id_seq'), 3, now(), '6', true),
                                                                        (nextval('answer_id_seq'), 3, now(), '2 + 4', true),

                                                                        (nextval('answer_id_seq'), 4, now(), '8', true),
                                                                        (nextval('answer_id_seq'), 4, now(), '4', false),
                                                                        (nextval('answer_id_seq'), 4, now(), '0', false),
                                                                        (nextval('answer_id_seq'), 4, now(), '0 + 8', true),

                                                                        (nextval('answer_id_seq'), 5, now(), '6', false),
                                                                        (nextval('answer_id_seq'), 5, now(), '18', false),
                                                                        (nextval('answer_id_seq'), 5, now(), '10', true),
                                                                        (nextval('answer_id_seq'), 5, now(), '9', false),
                                                                        (nextval('answer_id_seq'), 5, now(), '0', false),

                                                                        (nextval('answer_id_seq'), 6, now(), '3', false),
                                                                        (nextval('answer_id_seq'), 6, now(), '9', false),
                                                                        (nextval('answer_id_seq'), 6, now(), '0', false),
                                                                        (nextval('answer_id_seq'), 6, now(), '12', true),
                                                                        (nextval('answer_id_seq'), 6, now(), '5 + 7', true),

                                                                        (nextval('answer_id_seq'), 7, now(), '5', false),
                                                                        (nextval('answer_id_seq'), 7, now(), '14', true),

                                                                        (nextval('answer_id_seq'), 8, now(), '16', true),
                                                                        (nextval('answer_id_seq'), 8, now(), '12', false),
                                                                        (nextval('answer_id_seq'), 8, now(), '9', false),
                                                                        (nextval('answer_id_seq'), 8, now(), '5', false),

                                                                        (nextval('answer_id_seq'), 9, now(), '18', true),
                                                                        (nextval('answer_id_seq'), 9, now(), '9', false),
                                                                        (nextval('answer_id_seq'),9, now(), '17 + 1', true),
                                                                        (nextval('answer_id_seq'),9, now(), '2 + 16', true),

                                                                        (nextval('answer_id_seq'),10, now(), '0', false),
                                                                        (nextval('answer_id_seq'),10, now(), '2', false),
                                                                        (nextval('answer_id_seq'),10, now(), '8', false),
                                                                        (nextval('answer_id_seq'),10, now(), '20', true)
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('truncate question;');
        $this->addSql('truncate answer;');
    }
}
