<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105173354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, topic_id INT NOT NULL, auteur_id INT NOT NULL, contenu LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_5A8A6C8D1F55203D (topic_id), INDEX IDX_5A8A6C8D60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(30) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_9D40DE1BBCF5E72D (categorie_id), INDEX IDX_9D40DE1B60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D1F55203D');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D60BB6FE6');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BBCF5E72D');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B60BB6FE6');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE topic');
    }
}
