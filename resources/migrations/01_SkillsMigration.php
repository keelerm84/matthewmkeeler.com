<?php

namespace Migration;

use Knp\Migration\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class SkillsMigration extends AbstractMigration
{
    public function schemaUp(Schema $schema)
    {
        $skillsTable = $schema->createTable('skills');
        $skillsTable->addColumn('id', 'integer', array(
            'unsigned'      => true,
            'autoincrement' => true
        ));
        $skillsTable->addColumn('skill', 'string');
        $skillsTable->addColumn('months', 'integer');
        $skillsTable->addColumn('active', 'integer');
        $skillsTable->addColumn('rating', 'string');
        $skillsTable->setPrimaryKey(array('id'));
        $skillsTable->addUniqueIndex(array('skill'));
    }

    public function getMigrationInfo()
    {
        return 'Added skills table';
    }
}
