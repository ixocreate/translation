<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Entity;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Ixocreate\Type\Package\Entity\UuidType;
use Ixocreate\Entity\DatabaseEntityInterface;
use Ixocreate\Type\Package\TypeInterface;
use Ixocreate\Entity\Package\DefinitionCollection;
use Ixocreate\Entity\Package\EntityInterface;
use Ixocreate\Entity\Package\EntityTrait;

final class Definition implements EntityInterface, DatabaseEntityInterface
{
    use EntityTrait;

    /**
     * @var UuidType
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $catalogue;

    /**
     * @var array
     */
    private $files;

    /**
     * @var array
     */
    private $placeholders;

    /**
     * @return UuidType
     */
    public function id(): UuidType
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function catalogue(): string
    {
        return $this->catalogue;
    }

    /**
     * @return array
     */
    public function files(): array
    {
        return $this->files;
    }

    /**
     * @return array
     */
    public function placeholders(): array
    {
        return $this->placeholders;
    }

    /**
     * @return DefinitionCollection
     */
    protected static function createDefinitions(): DefinitionCollection
    {
        return new DefinitionCollection([
            new \Ixocreate\Entity\Package\Definition('id', UuidType::class, false, true),
            new \Ixocreate\Entity\Package\Definition('name', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Package\Definition('catalogue', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Package\Definition('files', TypeInterface::TYPE_ARRAY, false, true),
            new \Ixocreate\Entity\Package\Definition('placeholders', TypeInterface::TYPE_ARRAY, false, true),
        ]);
    }

    /**
     * @param ClassMetadataBuilder $builder
     */
    public static function loadMetadata(ClassMetadataBuilder $builder)
    {
        $builder->setTable('translation_definition');

        $builder->createField('id', UuidType::class)->makePrimaryKey()->build();
        $builder->createField('name', 'string')->build();
        $builder->createField('catalogue', 'string')->build();
        $builder->createField('files', Type::JSON)->build();
        $builder->createField('placeholders', Type::JSON)->build();
    }
}
