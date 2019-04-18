<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation\Entity;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Ixocreate\Package\Type\Entity\UuidType;
use Ixocreate\Entity\DatabaseEntityInterface;
use Ixocreate\Package\Type\TypeInterface;
use Ixocreate\Package\Entity\DefinitionCollection;
use Ixocreate\Package\Entity\EntityInterface;
use Ixocreate\Package\Entity\EntityTrait;

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
            new \Ixocreate\Package\Entity\Definition('id', UuidType::class, false, true),
            new \Ixocreate\Package\Entity\Definition('definitionId', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Package\Entity\Definition('locale', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Package\Entity\Definition('message', TypeInterface::TYPE_STRING, true, true),
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
