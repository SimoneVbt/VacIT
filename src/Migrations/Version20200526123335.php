<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526123335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sollicitatie (id INT AUTO_INCREMENT NOT NULL, vacature_id INT NOT NULL, user_id INT NOT NULL, motivatie VARCHAR(2000) NOT NULL, cv VARCHAR(100) NOT NULL, uitnodiging TINYINT(1) DEFAULT NULL, INDEX IDX_9577817D6FB89BA0 (vacature_id), INDEX IDX_9577817DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacature (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, plaatsingsdatum DATE NOT NULL, vacaturetitel VARCHAR(50) NOT NULL, vacaturetekst VARCHAR(5000) NOT NULL, afbeelding VARCHAR(50) DEFAULT NULL, werkniveau VARCHAR(50) NOT NULL, INDEX IDX_9E5830F5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sollicitatie ADD CONSTRAINT FK_9577817D6FB89BA0 FOREIGN KEY (vacature_id) REFERENCES vacature (id)');
        $this->addSql('ALTER TABLE sollicitatie ADD CONSTRAINT FK_9577817DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vacature ADD CONSTRAINT FK_9E5830F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD naam VARCHAR(50) NOT NULL, ADD voornaam VARCHAR(50) DEFAULT NULL, ADD geboortedatum DATE DEFAULT NULL, ADD telefoonnummer VARCHAR(20) DEFAULT NULL, ADD adres VARCHAR(50) NOT NULL, ADD postcode VARCHAR(10) NOT NULL, ADD plaats VARCHAR(50) NOT NULL, ADD afbeelding VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sollicitatie DROP FOREIGN KEY FK_9577817D6FB89BA0');
        $this->addSql('DROP TABLE sollicitatie');
        $this->addSql('DROP TABLE vacature');
        $this->addSql('ALTER TABLE user DROP naam, DROP voornaam, DROP geboortedatum, DROP telefoonnummer, DROP adres, DROP postcode, DROP plaats, DROP afbeelding');
    }
}
