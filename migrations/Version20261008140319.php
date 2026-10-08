<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261008140319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_anwser (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, is_right TINYINT NOT NULL, question_id INT DEFAULT NULL, INDEX IDX_DF101C111E27F6BF (question_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tbl_question (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, explication LONGTEXT DEFAULT NULL, theme_id INT NOT NULL, INDEX IDX_E1C4AF6359027487 (theme_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tbl_selected_answer (id INT AUTO_INCREMENT NOT NULL, selected_answer_x_time INT DEFAULT NULL, statistic_id INT DEFAULT NULL, answer_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_F85BB2ECAA334807 (answer_id), INDEX IDX_F85BB2EC53B6268F (statistic_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tbl_statistic (id INT AUTO_INCREMENT NOT NULL, t_moyen NUMERIC(10, 2) DEFAULT NULL, t_min NUMERIC(10, 2) DEFAULT NULL, t_max NUMERIC(10, 2) DEFAULT NULL, question_asked_x_time_ INT DEFAULT NULL, question_id INT NOT NULL, UNIQUE INDEX UNIQ_2113290F1E27F6BF (question_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tbl_theme (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE tbl_anwser ADD CONSTRAINT FK_DF101C111E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id)');
        $this->addSql('ALTER TABLE tbl_question ADD CONSTRAINT FK_E1C4AF6359027487 FOREIGN KEY (theme_id) REFERENCES tbl_theme (id)');
        $this->addSql('ALTER TABLE tbl_selected_answer ADD CONSTRAINT FK_F85BB2EC53B6268F FOREIGN KEY (statistic_id) REFERENCES tbl_statistic (id)');
        $this->addSql('ALTER TABLE tbl_selected_answer ADD CONSTRAINT FK_F85BB2ECAA334807 FOREIGN KEY (answer_id) REFERENCES tbl_anwser (id)');
        $this->addSql('ALTER TABLE tbl_statistic ADD CONSTRAINT FK_2113290F1E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_anwser DROP FOREIGN KEY FK_DF101C111E27F6BF');
        $this->addSql('ALTER TABLE tbl_question DROP FOREIGN KEY FK_E1C4AF6359027487');
        $this->addSql('ALTER TABLE tbl_selected_answer DROP FOREIGN KEY FK_F85BB2EC53B6268F');
        $this->addSql('ALTER TABLE tbl_selected_answer DROP FOREIGN KEY FK_F85BB2ECAA334807');
        $this->addSql('ALTER TABLE tbl_statistic DROP FOREIGN KEY FK_2113290F1E27F6BF');
        $this->addSql('DROP TABLE tbl_anwser');
        $this->addSql('DROP TABLE tbl_question');
        $this->addSql('DROP TABLE tbl_selected_answer');
        $this->addSql('DROP TABLE tbl_statistic');
        $this->addSql('DROP TABLE tbl_theme');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
