<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Ixocreate\Package\Database\Repository\AbstractRepository;
use Ixocreate\Package\Translation\Entity\Definition;
use Ixocreate\Package\Translation\Entity\Translation;

final class TranslationRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return Translation::class;
    }

    /**
     * @param string $locale
     * @param string $catalogue
     * @return array
     */
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
