<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116124734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade ADD topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE balade ADD CONSTRAINT FK_540083D71F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_540083D71F55203D ON balade (topic_id)');
        $this->addSql('ALTER TABLE seance ADD topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DF7DFD0E1F55203D ON seance (topic_id)');
        $this->addSql('ALTER TABLE topic CHANGE titre titre VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade DROP FOREIGN KEY FK_540083D71F55203D');
        $this->addSql('DROP INDEX UNIQ_540083D71F55203D ON balade');
        $this->addSql('ALTER TABLE balade DROP topic_id');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E1F55203D');
        $this->addSql('DROP INDEX UNIQ_DF7DFD0E1F55203D ON seance');
        $this->addSql('ALTER TABLE seance DROP topic_id');
        $this->addSql('ALTER TABLE topic CHANGE titre titre VARCHAR(30) NOT NULL');
    }
}
