<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201104833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE search_card (search_id INT NOT NULL, card_id INT NOT NULL, INDEX IDX_4D0E8DBA650760A9 (search_id), INDEX IDX_4D0E8DBA4ACC9A20 (card_id), PRIMARY KEY(search_id, card_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE search_card ADD CONSTRAINT FK_4D0E8DBA650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_card ADD CONSTRAINT FK_4D0E8DBA4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_card DROP FOREIGN KEY FK_4D0E8DBA650760A9');
        $this->addSql('ALTER TABLE search_card DROP FOREIGN KEY FK_4D0E8DBA4ACC9A20');
        $this->addSql('DROP TABLE search_card');
    }
}
