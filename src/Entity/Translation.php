<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Entity;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Ixocreate\Database\DatabaseEntityInterface;
use Ixocreate\Entity\DefinitionCollection;
use Ixocreate\Entity\EntityInterface;
use Ixocreate\Entity\EntityTrait;
use Ixocreate\Schema\Type\TypeInterface;
use Ixocreate\Schema\Type\UuidType;

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
            new \Ixocreate\Entity\Definition('id', UuidType::class, false, true),
            new \Ixocreate\Entity\Definition('definitionId', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Definition('locale', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Definition('message', TypeInterface::TYPE_STRING, true, true),
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
