<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Repository;

use Ixocreate\Database\Package\Repository\AbstractRepository;
use Ixocreate\Translation\Package\Entity\Definition;

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
