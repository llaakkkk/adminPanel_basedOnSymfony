<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170905152716 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

//        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE role_permissions DROP CONSTRAINT role_permissions_pkey;');
        $this->addSql('ALTER TABLE role_permissions ADD role_perm_id INT NOT NULL');
        $this->addSql('ALTER TABLE role_permissions ALTER perm_id DROP NOT NULL');
        $this->addSql('ALTER TABLE role_permissions ALTER role_id DROP NOT NULL');
        $this->addSql('CREATE INDEX IDX_1FBA94E6FA6311EF ON role_permissions (perm_id)');
        $this->addSql('ALTER TABLE role_permissions ADD PRIMARY KEY (role_perm_id)');
        $this->addSql('ALTER TABLE permissions ALTER perm_id DROP DEFAULT');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE roles_role_id_seq');
        $this->addSql('SELECT setval(\'roles_role_id_seq\', (SELECT MAX(role_id) FROM roles))');
        $this->addSql('ALTER TABLE roles ALTER role_id SET DEFAULT nextval(\'roles_role_id_seq\')');
        $this->addSql('CREATE SEQUENCE permissions_perm_id_seq');
        $this->addSql('SELECT setval(\'permissions_perm_id_seq\', (SELECT MAX(perm_id) FROM permissions))');
        $this->addSql('ALTER TABLE permissions ALTER perm_id SET DEFAULT nextval(\'permissions_perm_id_seq\')');
        $this->addSql('DROP INDEX IDX_1FBA94E6FA6311EF');
        $this->addSql('DROP INDEX role_permissions_pkey');
        $this->addSql('ALTER TABLE role_permissions DROP role_perm_id');
        $this->addSql('ALTER TABLE role_permissions ALTER role_id SET NOT NULL');
        $this->addSql('ALTER TABLE role_permissions ALTER perm_id SET NOT NULL');
        $this->addSql('ALTER TABLE role_permissions ADD PRIMARY KEY (perm_id)');
    }
}
