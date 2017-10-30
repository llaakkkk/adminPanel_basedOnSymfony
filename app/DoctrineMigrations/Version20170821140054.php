<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170821140054 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE TABLE admin_user
(
  id       INTEGER                                                  NOT NULL
    CONSTRAINT admin_user_pkey
    PRIMARY KEY,
  username VARCHAR(255)                                             NOT NULL,
  email    VARCHAR(255)                                             NOT NULL,
  password VARCHAR(255)                                             NOT NULL,
  roles    JSON,
  created  TIMESTAMP(0) DEFAULT NULL :: TIMESTAMP WITHOUT TIME ZONE NOT NULL,
  updated  TIMESTAMP(0) DEFAULT NULL :: TIMESTAMP WITHOUT TIME ZONE NOT NULL
);
');
        $this->addSql('CREATE UNIQUE INDEX uniq_ad8a54a9e7927c74
  ON admin_user (email);');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin_user ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE admin_user ALTER role DROP DEFAULT');
    }
}
