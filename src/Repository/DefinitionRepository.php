<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation\Repository;

use Ixocreate\Package\Database\Repository\AbstractRepository;
use Ixocreate\Package\Translation\Entity\Definition;

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
