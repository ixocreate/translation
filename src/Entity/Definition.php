<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation\Entity;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Ixocreate\Package\Type\Entity\UuidType;
use Ixocreate\Entity\DatabaseEntityInterface;
use Ixocreate\Package\Type\TypeInterface;
use Ixocreate\Package\Entity\DefinitionCollection;
use Ixocreate\Package\Entity\EntityInterface;
use Ixocreate\Package\Entity\EntityTrait;

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
            new \Ixocreate\Package\Entity\Definition('id', UuidType::class, false, true),
            new \Ixocreate\Package\Entity\Definition('name', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Package\Entity\Definition('catalogue', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Package\Entity\Definition('files', TypeInterface::TYPE_ARRAY, false, true),
            new \Ixocreate\Package\Entity\Definition('placeholders', TypeInterface::TYPE_ARRAY, false, true),
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
