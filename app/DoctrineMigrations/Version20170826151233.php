<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170826151233 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE acl_entries DROP CONSTRAINT fk_46c8b806ea000b10');
        $this->addSql('ALTER TABLE acl_entries DROP CONSTRAINT fk_46c8b806df9183c9');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP CONSTRAINT fk_825de2993d9ab4a6');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP CONSTRAINT fk_825de299c671cea1');
        $this->addSql('ALTER TABLE acl_entries DROP CONSTRAINT fk_46c8b8063d9ab4a6');
        $this->addSql('ALTER TABLE acl_object_identities DROP CONSTRAINT fk_9407e54977fa751a');
        $this->addSql('ALTER TABLE role_permissions DROP CONSTRAINT fk_1fba94e6fa6311ef');
        $this->addSql('ALTER TABLE admin_user DROP CONSTRAINT fk_ad8a54a9d60322ac');
        $this->addSql('ALTER TABLE role_permissions DROP CONSTRAINT fk_1fba94e6d60322ac');
        $this->addSql('DROP SEQUENCE acl_entries_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE acl_classes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE acl_security_identities_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE acl_object_identities_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE roles_role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE permissions_perm_id_seq CASCADE');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_classes');
        $this->addSql('DROP TABLE acl_security_identities');
        $this->addSql('DROP TABLE acl_entries');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE role_permissions');
        $this->addSql('DROP TABLE roles');
//        $this->addSql('DROP INDEX IDX_AD8A54A9D60322AC');
        $this->addSql('ALTER TABLE admin_user ADD roles JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_user DROP role_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE acl_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE acl_classes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE acl_security_identities_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE acl_object_identities_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE roles_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE permissions_perm_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INT NOT NULL, ancestor_id INT NOT NULL, PRIMARY KEY(object_identity_id, ancestor_id))');
        $this->addSql('CREATE INDEX idx_825de2993d9ab4a6 ON acl_object_identity_ancestors (object_identity_id)');
        $this->addSql('CREATE INDEX idx_825de299c671cea1 ON acl_object_identity_ancestors (ancestor_id)');
        $this->addSql('CREATE TABLE acl_classes (id SERIAL NOT NULL, class_type VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_69dd750638a36066 ON acl_classes (class_type)');
        $this->addSql('CREATE TABLE acl_security_identities (id SERIAL NOT NULL, identifier VARCHAR(200) NOT NULL, username BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8835ee78772e836af85e0677 ON acl_security_identities (identifier, username)');
        $this->addSql('CREATE TABLE acl_entries (id SERIAL NOT NULL, class_id INT NOT NULL, object_identity_id INT DEFAULT NULL, security_identity_id INT NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT NOT NULL, mask INT NOT NULL, granting BOOLEAN NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success BOOLEAN NOT NULL, audit_failure BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_46c8b806df9183c9 ON acl_entries (security_identity_id)');
        $this->addSql('CREATE INDEX idx_46c8b806ea000b10 ON acl_entries (class_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_46c8b806ea000b103d9ab4a64def17bce4289bf4 ON acl_entries (class_id, object_identity_id, field_name, ace_order)');
        $this->addSql('CREATE INDEX idx_46c8b806ea000b103d9ab4a6df9183c9 ON acl_entries (class_id, object_identity_id, security_identity_id)');
        $this->addSql('CREATE INDEX idx_46c8b8063d9ab4a6 ON acl_entries (object_identity_id)');
        $this->addSql('CREATE TABLE acl_object_identities (id SERIAL NOT NULL, parent_object_identity_id INT DEFAULT NULL, class_id INT NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_9407e5494b12ad6ea000b10 ON acl_object_identities (object_identifier, class_id)');
        $this->addSql('CREATE INDEX idx_9407e54977fa751a ON acl_object_identities (parent_object_identity_id)');
        $this->addSql('CREATE TABLE permissions (perm_id SERIAL NOT NULL, perm_desc VARCHAR(50) NOT NULL, PRIMARY KEY(perm_id))');
        $this->addSql('CREATE TABLE role_permissions (perm_id INT NOT NULL, role_id INT NOT NULL, PRIMARY KEY(perm_id))');
        $this->addSql('CREATE INDEX idx_1fba94e6d60322ac ON role_permissions (role_id)');
        $this->addSql('CREATE TABLE roles (role_id SERIAL NOT NULL, role_name VARCHAR(255) NOT NULL, PRIMARY KEY(role_id))');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT fk_825de2993d9ab4a6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT fk_825de299c671cea1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT fk_46c8b806ea000b10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT fk_46c8b8063d9ab4a6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT fk_46c8b806df9183c9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE acl_object_identities ADD CONSTRAINT fk_9407e54977fa751a FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT fk_1fba94e6d60322ac FOREIGN KEY (role_id) REFERENCES roles (role_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT fk_1fba94e6fa6311ef FOREIGN KEY (perm_id) REFERENCES permissions (perm_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_user ADD role_id INT NOT NULL');
        $this->addSql('ALTER TABLE admin_user DROP roles');
        $this->addSql('ALTER TABLE admin_user ADD CONSTRAINT fk_ad8a54a9d60322ac FOREIGN KEY (role_id) REFERENCES roles (role_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AD8A54A9D60322AC ON admin_user (role_id)');
    }
}
