<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250102003940 extends AbstractMigration
{
    // public function getDescription(): string
    // {
    //     return '';
    // }

    public function up(Schema $schema): void
    {
        // // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE user ADD customer_id VARCHAR(255) NOT NULL, ADD movies_liked JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD movies_disliked JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD movies_watched JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD movies_to_watch JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD comments JSON DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499395C3F3 ON user (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP INDEX UNIQ_8D93D6499395C3F3 ON user');
        // $this->addSql('ALTER TABLE user DROP customer_id, DROP movies_liked, DROP movies_disliked, DROP movies_watched, DROP movies_to_watch, DROP comments');
    }
}
