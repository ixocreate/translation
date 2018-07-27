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
namespace KiwiSuite\Translation\Repository;

use KiwiSuite\Database\Repository\AbstractRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use KiwiSuite\Translation\DefinitionMetadata;
use KiwiSuite\Translation\Entity\Definition;

final class DefinitionRepository extends AbstractRepository
{

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return Definition::class;
    }

    public function loadMetadata(ClassMetadataBuilder $builder): void
    {
        $metadata = (new DefinitionMetadata($builder));
    }
}
