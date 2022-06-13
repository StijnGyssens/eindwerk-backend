<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613072431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_event (group_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_6B8221C0FE54D947 (group_id), INDEX IDX_6B8221C071F7E88B (event_id), PRIMARY KEY(group_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_member (group_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_A36222A8FE54D947 (group_id), INDEX IDX_A36222A87597D3FE (member_id), PRIMARY KEY(group_id, member_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_media (id INT AUTO_INCREMENT NOT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_event ADD CONSTRAINT FK_6B8221C0FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_event ADD CONSTRAINT FK_6B8221C071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_member ADD CONSTRAINT FK_A36222A8FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_member ADD CONSTRAINT FK_A36222A87597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD socials_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74284E315 FOREIGN KEY (socials_id) REFERENCES social_media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA74284E315 ON event (socials_id)');
        $this->addSql('ALTER TABLE `group` ADD fighting_style_id INT DEFAULT NULL, ADD historical_region_id INT NOT NULL, ADD timeperiode_id INT NOT NULL');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C513949A02 FOREIGN KEY (fighting_style_id) REFERENCES style (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C56B5DB18A FOREIGN KEY (historical_region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C52C6E6B0A FOREIGN KEY (timeperiode_id) REFERENCES timeperiode (id)');
        $this->addSql('CREATE INDEX IDX_6DC044C513949A02 ON `group` (fighting_style_id)');
        $this->addSql('CREATE INDEX IDX_6DC044C56B5DB18A ON `group` (historical_region_id)');
        $this->addSql('CREATE INDEX IDX_6DC044C52C6E6B0A ON `group` (timeperiode_id)');
        $this->addSql('ALTER TABLE member ADD socials_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA784284E315 FOREIGN KEY (socials_id) REFERENCES social_media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA784284E315 ON member (socials_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74284E315');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA784284E315');
        $this->addSql('DROP TABLE group_event');
        $this->addSql('DROP TABLE group_member');
        $this->addSql('DROP TABLE social_media');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA74284E315 ON event');
        $this->addSql('ALTER TABLE event DROP socials_id');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C513949A02');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C56B5DB18A');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C52C6E6B0A');
        $this->addSql('DROP INDEX IDX_6DC044C513949A02 ON `group`');
        $this->addSql('DROP INDEX IDX_6DC044C56B5DB18A ON `group`');
        $this->addSql('DROP INDEX IDX_6DC044C52C6E6B0A ON `group`');
        $this->addSql('ALTER TABLE `group` DROP fighting_style_id, DROP historical_region_id, DROP timeperiode_id');
        $this->addSql('DROP INDEX UNIQ_70E4FA784284E315 ON member');
        $this->addSql('ALTER TABLE member DROP socials_id');
    }
}
