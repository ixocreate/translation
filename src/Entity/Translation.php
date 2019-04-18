<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Entity;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Ixocreate\Type\Package\Entity\UuidType;
use Ixocreate\Entity\DatabaseEntityInterface;
use Ixocreate\Type\Package\TypeInterface;
use Ixocreate\Entity\Package\DefinitionCollection;
use Ixocreate\Entity\Package\EntityInterface;
use Ixocreate\Entity\Package\EntityTrait;

final class Translation implements EntityInterface, DatabaseEntityInterface
{
    use EntityTrait;

    /**
     * @var UuidType
     */
    private $id;

    /**
     * @var string
     */
    private $definitionId;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $message;

    public function id(): UuidType
    {
        return $this->id;
    }

    public function definitionId(): string
    {
        return $this->definitionId;
    }

    public function locale(): string
    {
        return $this->locale;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    /**
     * @return DefinitionCollection
     */
    protected static function createDefinitions(): DefinitionCollection
    {
        return new DefinitionCollection([
            new \Ixocreate\Entity\Package\Definition('id', UuidType::class, false, true),
            new \Ixocreate\Entity\Package\Definition('definitionId', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Package\Definition('locale', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Package\Definition('message', TypeInterface::TYPE_STRING, true, true),
        ]);
    }

    /**
     * @param ClassMetadataBuilder $builder
     */
    public static function loadMetadata(ClassMetadataBuilder $builder)
    {
        $builder->setTable('translation_translation');

        $builder->createField('id', UuidType::class)->makePrimaryKey()->build();
        $builder->createField('definitionId', 'string')->build();
        $builder->createField('locale', 'string')->build();
        $builder->createField('message', 'text')->build();
    }
}
