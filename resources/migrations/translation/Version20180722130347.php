<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use Ixocreate\Schema\Type\UuidType;

class Version20180722130347 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('translation_definition');
        $table->addColumn('id', UuidType::serviceName());
        $table->addColumn('name', Types::STRING);
        $table->addColumn('catalogue', Types::STRING);
        $table->addColumn('files', Types::JSON);
        $table->addColumn('placeholders', Types::JSON);

        $table->setPrimaryKey(['id']);

        $table = $schema->createTable('translation_translation');
        $table->addColumn('id', UuidType::serviceName());
        $table->addColumn('definitionId', UuidType::serviceName());
        $table->addColumn('locale', Types::STRING);
        $table->addColumn('message', Types::TEXT)->setNotnull(false);

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('translation_definition', ['definitionId'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addUniqueIndex(['definitionId', 'locale']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('translation_definition');
        $schema->dropTable('translation_translation');
    }
}
