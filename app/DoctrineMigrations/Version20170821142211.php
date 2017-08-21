<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170821142211 extends AbstractMigration implements ContainerAwareInterface
{
    const ROLES_TABLE_NAME = 'roles';
    const PERMISSIONS_TABLE_NAME = 'permissions';
    const ROLE_PERMISSIONS_TABLE_NAME = 'role_permissions';
    const USERS_TABLE_NAME = 'admin_user';

    private $container;

    /**
     * @param null|ContainerInterface $container
     * @return mixed
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // this up() migration is auto-generated, please modify it to your needs
        // roles table
        $rolesTable = $schema->createTable(self::ROLES_TABLE_NAME);
        $rolesTable->addColumn('role_id', 'integer', ['autoincrement' => true]);
        $rolesTable->addColumn('role_name', 'string', ['length' => 255, 'notnull' => true]);
        $rolesTable->setPrimaryKey(array('role_id'));

        //permissions tables
        $permissionsTable = $schema->createTable(self::PERMISSIONS_TABLE_NAME);
        $permissionsTable->addColumn('perm_id', 'integer', ['autoincrement' => true]);
        $permissionsTable->addColumn('perm_desc', 'string', ['length' => 50, 'notnull' => true]);
        $permissionsTable->setPrimaryKey(array('perm_id'));

        //role_permissions tables
        $rolePermissionsTable = $schema->createTable(self::ROLE_PERMISSIONS_TABLE_NAME);
        $rolePermissionsTable->addColumn('role_id', 'integer', ['length' => 11, 'notnull' => true]);
        $rolePermissionsTable->addColumn('perm_id', 'integer', ['length' => 11, 'notnull' => true]);
        $rolePermissionsTable->setPrimaryKey(array('perm_id'));

        $roles = $schema->getTable(self::ROLES_TABLE_NAME);
        $permissions = $schema->getTable(self::PERMISSIONS_TABLE_NAME);
        $rolePermissionsTable->addForeignKeyConstraint($roles, ['role_id'], ['role_id']);
        $rolePermissionsTable->addForeignKeyConstraint($permissions, ['perm_id'], ['perm_id']);

//        $users = $schema->getTable(self::USERS_TABLE_NAME);
//
//        $users->setPrimaryKey(array('id'));
//
//        $users->addForeignKeyConstraint($roles, ['role_id'], ['role_id']);
//        $sql = "INSERT INTO `%s` (`role_id`, `role_name`) VALUES (NULL, '%s');";
//        $this->addSql(sprintf($sql,self::ROLES_TABLE_NAME, 'ROLE_ADMIN'));

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable(self::ROLES_TABLE_NAME);
        $schema->dropTable(self::PERMISSIONS_TABLE_NAME);
        $schema->dropTable(self::ROLE_PERMISSIONS_TABLE_NAME);
    }


}