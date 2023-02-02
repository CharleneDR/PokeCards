<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201104708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, api_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, image_large VARCHAR(255) NOT NULL, image_small VARCHAR(255) NOT NULL, type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', supertype VARCHAR(255) NOT NULL, series VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, total_set INT NOT NULL, rarity VARCHAR(255) NOT NULL, printed_total INT NOT NULL, trend_price INT NOT NULL, artist VARCHAR(255) NOT NULL, evolves_to VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE card');
    }
}
