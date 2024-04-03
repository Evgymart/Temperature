<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403150751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates a table for temperature reading';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE temperature_reading (
            id INT GENERATED ALWAYS AS IDENTITY,
            sensor_uuid VARCHAR(255) NOT NULL,
            reading_time TIMESTAMP NOT NULL,
            temperature DOUBLE PRECISION NOT NULL
        );
SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE temperature_reading;");
    }
}
