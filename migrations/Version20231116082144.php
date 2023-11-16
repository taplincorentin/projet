<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116082144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chien_race DROP FOREIGN KEY FK_B584F83FBFCF400E');
        $this->addSql('DROP TABLE chien_race');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chien_race (id INT AUTO_INCREMENT NOT NULL, chien_id INT DEFAULT NULL, nom_race VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5B5D7EE8BFCF400E (chien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chien_race ADD CONSTRAINT FK_B584F83FBFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
