<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250102005033 extends AbstractMigration
{
    // public function getDescription(): string
    // {
    //     return '';
    // }

    public function up(Schema $schema): void
    {
        // // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP INDEX UNIQ_8D93D6499395C3F3 ON user');
        // $this->addSql('ALTER TABLE user CHANGE customer_id custom_id VARCHAR(255) NOT NULL');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649614A603A ON user (custom_id)');
    }

    public function down(Schema $schema): void
    {
        // // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP INDEX UNIQ_8D93D649614A603A ON user');
        // $this->addSql('ALTER TABLE user CHANGE custom_id customer_id VARCHAR(255) NOT NULL');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499395C3F3 ON user (customer_id)');
    }
}
