<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020095552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chien (id INT AUTO_INCREMENT NOT NULL, personne_id INT NOT NULL, nom VARCHAR(20) NOT NULL, date_de_naissance DATE NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_13A4067EA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chien_race (chien_id INT NOT NULL, race_id INT NOT NULL, INDEX IDX_5B5D7EE8BFCF400E (chien_id), INDEX IDX_5B5D7EE86E59D40D (race_id), PRIMARY KEY(chien_id, race_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, is_educateur TINYINT(1) NOT NULL, description_educateur LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_FCEC9EF86CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chien ADD CONSTRAINT FK_13A4067EA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE chien_race ADD CONSTRAINT FK_5B5D7EE8BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chien_race ADD CONSTRAINT FK_5B5D7EE86E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chien DROP FOREIGN KEY FK_13A4067EA21BD112');
        $this->addSql('ALTER TABLE chien_race DROP FOREIGN KEY FK_5B5D7EE8BFCF400E');
        $this->addSql('ALTER TABLE chien_race DROP FOREIGN KEY FK_5B5D7EE86E59D40D');
        $this->addSql('DROP TABLE chien');
        $this->addSql('DROP TABLE chien_race');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
