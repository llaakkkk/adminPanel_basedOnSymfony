<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170821150235 extends AbstractMigration
{
    const ROLES_TABLE_NAME = 'roles';
    const USERS_TABLE_NAME = 'admin_user';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $users = $schema->getTable(self::USERS_TABLE_NAME);

//        $users->setPrimaryKey(array('id'));

        $roles = $schema->getTable(self::ROLES_TABLE_NAME);

        $sql = "INSERT INTO %s (role_name) VALUES ('%s');";
        $this->addSql(sprintf($sql,self::ROLES_TABLE_NAME, 'ROLE_ADMIN'));

//        $users->addForeignKeyConstraint($roles, ['role_id'], ['role_id']);


    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
