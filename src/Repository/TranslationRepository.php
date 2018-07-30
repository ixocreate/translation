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

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use KiwiSuite\Database\Repository\AbstractRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use KiwiSuite\Translation\Entity\Definition;
use KiwiSuite\Translation\Entity\Translation;
use KiwiSuite\Translation\Metadata\TranslationMetadata;

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

    public function loadTranslations(string $locale, string $catalogue): array
    {
        $queryBuilder = $this->createSelectQueryBuilder('t');
        $queryBuilder->join(Definition::class, 'd', Join::WITH, 'd.id = t.definitionId');
        $queryBuilder->addSelect(['d.name', 'd.catalogue']);
        $queryBuilder->andWhere('t.locale = :locale');
        $queryBuilder->setParameter("locale", $locale);
        $queryBuilder->andWhere("d.catalogue = :catalogue");
        $queryBuilder->setParameter("catalogue", $catalogue);

        $result = $queryBuilder->getQuery()->getResult(Query::HYDRATE_SCALAR);
        $translations = [];

        foreach ($result as $item) {
            if (!isset($translations[$item['catalogue']])) {
                $translations[$item['catalogue']] = [];
            }
            $translations[$item['catalogue']][$item['name']] = $item['t_message'];
        }

        return $translations;
    }
}
