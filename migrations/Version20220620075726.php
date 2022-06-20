<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620075726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, socials_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_3BAE0AA74284E315 (socials_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, fighting_style_id INT DEFAULT NULL, historical_region_id INT NOT NULL, timeperiode_id INT NOT NULL, socials_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_6DC044C513949A02 (fighting_style_id), INDEX IDX_6DC044C56B5DB18A (historical_region_id), INDEX IDX_6DC044C52C6E6B0A (timeperiode_id), UNIQUE INDEX UNIQ_6DC044C54284E315 (socials_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_event (group_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_6B8221C0FE54D947 (group_id), INDEX IDX_6B8221C071F7E88B (event_id), PRIMARY KEY(group_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_member (group_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_A36222A8FE54D947 (group_id), INDEX IDX_A36222A87597D3FE (member_id), PRIMARY KEY(group_id, member_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, socials_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, leader TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_70E4FA78E7927C74 (email), UNIQUE INDEX UNIQ_70E4FA784284E315 (socials_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, historical_region VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_media (id INT AUTO_INCREMENT NOT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE style (id INT AUTO_INCREMENT NOT NULL, fighting_style VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE timeperiode (id INT AUTO_INCREMENT NOT NULL, timeperiode VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74284E315 FOREIGN KEY (socials_id) REFERENCES social_media (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C513949A02 FOREIGN KEY (fighting_style_id) REFERENCES style (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C56B5DB18A FOREIGN KEY (historical_region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C52C6E6B0A FOREIGN KEY (timeperiode_id) REFERENCES timeperiode (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C54284E315 FOREIGN KEY (socials_id) REFERENCES social_media (id)');
        $this->addSql('ALTER TABLE group_event ADD CONSTRAINT FK_6B8221C0FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_event ADD CONSTRAINT FK_6B8221C071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_member ADD CONSTRAINT FK_A36222A8FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_member ADD CONSTRAINT FK_A36222A87597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA784284E315 FOREIGN KEY (socials_id) REFERENCES social_media (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_event DROP FOREIGN KEY FK_6B8221C071F7E88B');
        $this->addSql('ALTER TABLE group_event DROP FOREIGN KEY FK_6B8221C0FE54D947');
        $this->addSql('ALTER TABLE group_member DROP FOREIGN KEY FK_A36222A8FE54D947');
        $this->addSql('ALTER TABLE group_member DROP FOREIGN KEY FK_A36222A87597D3FE');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C56B5DB18A');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74284E315');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C54284E315');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA784284E315');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C513949A02');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C52C6E6B0A');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_event');
        $this->addSql('DROP TABLE group_member');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE social_media');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE timeperiode');
    }
}
