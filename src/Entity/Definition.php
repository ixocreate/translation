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

final class Definition implements EntityInterface
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
            new \KiwiSuite\Entity\Entity\Definition('id', UuidType::class, false, true),
            new \KiwiSuite\Entity\Entity\Definition('name', TypeInterface::TYPE_STRING, false, true),
            new \KiwiSuite\Entity\Entity\Definition('catalogue', TypeInterface::TYPE_STRING, false, true),
            new \KiwiSuite\Entity\Entity\Definition('files', TypeInterface::TYPE_ARRAY, false, true),
            new \KiwiSuite\Entity\Entity\Definition('placeholders', TypeInterface::TYPE_ARRAY, false, true),
        ]);
    }
}
