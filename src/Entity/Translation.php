<?php
/**
 * kiwi-suite/translation (https://github.com/kiwi-suite/translation)
 *
 * @package kiwi-suite/translation
 * @link https://github.com/kiwi-suite/translation
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuite\Translation\Entity;

use KiwiSuite\CommonTypes\Entity\UuidType;
use KiwiSuite\Contract\Type\TypeInterface;
use KiwiSuite\Entity\Entity\DefinitionCollection;
use KiwiSuite\Entity\Entity\EntityInterface;
use KiwiSuite\Entity\Entity\EntityTrait;

final class Translation implements EntityInterface
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
            new \KiwiSuite\Entity\Entity\Definition('id', UuidType::class, false, true),
            new \KiwiSuite\Entity\Entity\Definition('definitionId', TypeInterface::TYPE_STRING, false, true),
            new \KiwiSuite\Entity\Entity\Definition('locale', TypeInterface::TYPE_STRING, false, true),
            new \KiwiSuite\Entity\Entity\Definition('message', TypeInterface::TYPE_STRING, true, true),
        ]);
    }
}
