<?php declare(strict_types = 1);

namespace KiwiMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;
use KiwiSuite\CommonTypes\Entity\UuidType;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180722130347 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $table = $schema->createTable('translation_definition');
        $table->addColumn('id', UuidType::class);
        $table->addColumn("name", Type::STRING);
        $table->addColumn("catalogue", Type::STRING);
        $table->addColumn("files", Type::JSON);
        $table->addColumn("placeholders", Type::JSON);
        $table->setPrimaryKey(["id"]);

        $table = $schema->createTable('translation_translation');
        $table->addColumn("id", UuidType::class);
        $table->addColumn("definitionId", UuidType::class);
        $table->addColumn("locale", Type::STRING);
        $table->addColumn("message", Type::TEXT)->setNotnull(false);
        $table->setPrimaryKey(["id"]);
        $table->addForeignKeyConstraint('translation_definition', ['definitionId'], ['id'], ["onDelete" => "CASCADE"]);
        $table->addUniqueIndex(["definitionId", "locale"]);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable("translation_definition");
        $schema->dropTable("translation_translation");
    }
}
