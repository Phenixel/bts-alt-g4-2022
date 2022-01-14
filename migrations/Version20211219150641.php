<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211219150641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dosage (id INT AUTO_INCREMENT NOT NULL, dos_code INT NOT NULL, dos_quantite VARCHAR(10) DEFAULT NULL, dos_unite VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, med_depotlegal INT NOT NULL, med_nomcommercial VARCHAR(25) DEFAULT NULL, fam_code INT NOT NULL, med_composition VARCHAR(255) DEFAULT NULL, med_effets VARCHAR(255) DEFAULT NULL, med_contreindic VARCHAR(255) DEFAULT NULL, med_prixechantillon DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescrire (id INT AUTO_INCREMENT NOT NULL, med_depotlegal VARCHAR(255) NOT NULL, tin_code INT NOT NULL, dos_code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_individu (id INT AUTO_INCREMENT NOT NULL, tin_code INT NOT NULL, tin_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dosage');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE prescrire');
        $this->addSql('DROP TABLE type_individu');
        $this->addSql('DROP TABLE user');
    }
}
