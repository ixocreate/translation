<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Entity;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Ixocreate\CommonTypes\Entity\UuidType;
use Ixocreate\Contract\Entity\DatabaseEntityInterface;
use Ixocreate\Contract\Type\TypeInterface;
use Ixocreate\Entity\Entity\DefinitionCollection;
use Ixocreate\Entity\Entity\EntityInterface;
use Ixocreate\Entity\Entity\EntityTrait;

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
            new \Ixocreate\Entity\Entity\Definition('id', UuidType::class, false, true),
            new \Ixocreate\Entity\Entity\Definition('definitionId', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Entity\Definition('locale', TypeInterface::TYPE_STRING, false, true),
            new \Ixocreate\Entity\Entity\Definition('message', TypeInterface::TYPE_STRING, true, true),
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
