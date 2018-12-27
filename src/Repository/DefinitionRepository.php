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

namespace Ixocreate\Translation\Repository;

use Ixocreate\Database\Repository\AbstractRepository;
use Ixocreate\Translation\Entity\Definition;

final class DefinitionRepository extends AbstractRepository
{

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return Definition::class;
    }
}
