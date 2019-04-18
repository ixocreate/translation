<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Ixocreate\Database\Package\Repository\AbstractRepository;
use Ixocreate\Translation\Package\Entity\Definition;
use Ixocreate\Translation\Package\Entity\Translation;

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
