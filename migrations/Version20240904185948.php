<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904185948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE measuring ADD sensor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE measuring ADD wine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE measuring ADD CONSTRAINT FK_ECF3A169A247991F FOREIGN KEY (sensor_id) REFERENCES sensor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE measuring ADD CONSTRAINT FK_ECF3A16928A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_ECF3A169A247991F ON measuring (sensor_id)');
        $this->addSql('CREATE INDEX IDX_ECF3A16928A2BD76 ON measuring (wine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE measuring DROP CONSTRAINT FK_ECF3A169A247991F');
        $this->addSql('ALTER TABLE measuring DROP CONSTRAINT FK_ECF3A16928A2BD76');
        $this->addSql('DROP INDEX IDX_ECF3A169A247991F');
        $this->addSql('DROP INDEX IDX_ECF3A16928A2BD76');
        $this->addSql('ALTER TABLE measuring DROP sensor_id');
        $this->addSql('ALTER TABLE measuring DROP wine_id');
    }
}
