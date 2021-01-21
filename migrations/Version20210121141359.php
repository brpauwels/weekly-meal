<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210121141359 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE domain_messages (
                    event_id UUID NOT NULL,
                    event_type VARCHAR(255) NOT NULL,
                    aggregate_root_id UUID NOT NULL,
                    aggregate_root_version INTEGER NOT NULL,
                    time_of_recording TIMESTAMP(6) WITH TIME ZONE NOT NULL,
                    payload JSON NOT NULL,
                    PRIMARY KEY(event_id))'
        );

        $this->addSql(
            'CREATE UNIQUE INDEX unique_id_and_version ON domain_messages (
                    aggregate_root_id,
                    aggregate_root_version ASC)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE domain_messages');
    }
}
