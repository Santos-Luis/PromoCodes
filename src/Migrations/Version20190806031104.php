<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806031104 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PromoCode CHANGE id id VARCHAR(8) NOT NULL, CHANGE owner owner VARCHAR(50) NOT NULL, CHANGE discount_percentage discount_percentage INT NOT NULL, CHANGE expiration_date expiration_date DATETIME NOT NULL, CHANGE created_by created_by VARCHAR(50) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE edited_at edited_at DATETIME NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE PromoCode DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE PromoCode CHANGE id id VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, CHANGE owner owner VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, CHANGE discount_percentage discount_percentage INT DEFAULT NULL, CHANGE expiration_date expiration_date DATETIME DEFAULT NULL, CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE edited_at edited_at DATETIME DEFAULT NULL');
    }
}
