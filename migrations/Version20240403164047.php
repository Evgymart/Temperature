<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403164047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique constraint to sensor_uuid';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            ALTER TABLE temperature_reading ADD CONSTRAINT uc_temperature_reading UNIQUE(sensor_uuid);
SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
            ALTER TABLE temperature_reading DROP CONSTRAINT uc_temperature_reading; 
SQL;
        $this->addSql($sql);
    }
}
