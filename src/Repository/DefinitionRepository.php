<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
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
