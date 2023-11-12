<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231112181427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chien_race RENAME INDEX idx_b584f83fbfcf400e TO IDX_5B5D7EE8BFCF400E');
        $this->addSql('ALTER TABLE post CHANGE auteur_id auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic CHANGE auteur_id auteur_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chien_race RENAME INDEX idx_5b5d7ee8bfcf400e TO IDX_B584F83FBFCF400E');
        $this->addSql('ALTER TABLE post CHANGE auteur_id auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE topic CHANGE auteur_id auteur_id INT NOT NULL');
    }
}
