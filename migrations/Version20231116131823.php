<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116131823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE seance CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE topic CHANGE titre titre VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade CHANGE nom nom VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE seance CHANGE nom nom VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE topic CHANGE titre titre VARCHAR(50) NOT NULL');
    }
}
