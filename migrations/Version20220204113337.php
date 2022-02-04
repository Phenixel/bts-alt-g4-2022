<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204113337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dosage (id INT AUTO_INCREMENT NOT NULL, dos_code INT NOT NULL, dos_quantite VARCHAR(10) DEFAULT NULL, dos_unite VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE famille DROP fam_code');
        $this->addSql('ALTER TABLE type_individu DROP tin_code');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dosage');
        $this->addSql('ALTER TABLE famille ADD fam_code INT NOT NULL');
        $this->addSql('ALTER TABLE type_individu ADD tin_code INT NOT NULL');
    }
}
