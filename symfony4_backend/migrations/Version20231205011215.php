<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205011215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" ADD date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD customer VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD address1 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD postcode VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD amount INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD deleted VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD last_modified TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP date');
        $this->addSql('ALTER TABLE "order" DROP customer');
        $this->addSql('ALTER TABLE "order" DROP address1');
        $this->addSql('ALTER TABLE "order" DROP city');
        $this->addSql('ALTER TABLE "order" DROP postcode');
        $this->addSql('ALTER TABLE "order" DROP country');
        $this->addSql('ALTER TABLE "order" DROP amount');
        $this->addSql('ALTER TABLE "order" DROP status');
        $this->addSql('ALTER TABLE "order" DROP deleted');
        $this->addSql('ALTER TABLE "order" DROP last_modified');
    }
}
