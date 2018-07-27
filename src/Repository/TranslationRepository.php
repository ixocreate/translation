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

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use KiwiSuite\Database\Repository\AbstractRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use KiwiSuite\Entity\Collection\ArrayCollection;
use KiwiSuite\Translation\Entity\Definition;
use KiwiSuite\Translation\Entity\Translation;
use KiwiSuite\Translation\TranslationMetadata;

final class TranslationRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return Translation::class;
    }

    public function loadMetadata(ClassMetadataBuilder $builder): void
    {
        $metadata = (new TranslationMetadata($builder));
    }

    public function loadTranslations(string $locale, string $catalogue): ArrayCollection
    {
        $queryBuilder = $this->createSelectQueryBuilder('t');
        $queryBuilder->join(Definition::class, 'd', Join::WITH, 'd.id = t.definitionId');
        $queryBuilder->addSelect(['d.name']);
        $queryBuilder->andWhere(Criteria::expr()->eq('d.locale', $locale));
        $queryBuilder->andWhere(Criteria::expr()->eq('d.catalogue', $catalogue));

        return new ArrayCollection($queryBuilder->getQuery()->getResult(Query::HYDRATE_SCALAR), function ($definition) {
            return (string) $definition->id();
        });
    }
}
