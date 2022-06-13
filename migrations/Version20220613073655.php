<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613073655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `group` ADD socials_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C54284E315 FOREIGN KEY (socials_id) REFERENCES social_media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DC044C54284E315 ON `group` (socials_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C54284E315');
        $this->addSql('DROP INDEX UNIQ_6DC044C54284E315 ON `group`');
        $this->addSql('ALTER TABLE `group` DROP socials_id');
    }
}
