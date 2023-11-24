<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124150534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade CHANGE ville ville VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE personne DROP description_educateur');
        $this->addSql('ALTER TABLE seance CHANGE ville ville VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE theme CHANGE nom nom VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade CHANGE ville ville VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE seance CHANGE ville ville VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE theme CHANGE nom nom VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE personne ADD description_educateur LONGTEXT DEFAULT NULL');
    }
}
