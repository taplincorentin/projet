<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111181119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chien_races (id INT AUTO_INCREMENT NOT NULL, chien_id INT DEFAULT NULL, nom_race VARCHAR(30) NOT NULL, INDEX IDX_B584F83FBFCF400E (chien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chien_races ADD CONSTRAINT FK_B584F83FBFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chien_races DROP FOREIGN KEY FK_B584F83FBFCF400E');
        $this->addSql('DROP TABLE chien_races');
    }
}
